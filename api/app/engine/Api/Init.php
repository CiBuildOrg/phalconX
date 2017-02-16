<?php
namespace Engine\Api;

use Phalcon\{
    DI,
    Loader as PhLoader,
    Mvc\Url as PhUrl,
    Mvc\Model\Transaction\Manager as TxManager,
    Mvc\Model\Manager as PhModelsManager,
    Mvc\Model\MetaData\Strategy\Annotations as PhStrategyAnnotations,
    Mvc\Model\MetaData\Memory as PhMetadataMemory,
    Mvc\Router\Annotations as PhRouterAnnotations,
    Mvc\Router as PhRouter,
    Annotations\Adapter\Memory as PhAnnotationsMemory,
    Events\Manager as PhEventsManager,
    Cache\Frontend\Data as PhCacheData,
    Cache\Frontend\Output as PhCacheOutput,
    Db\Adapter\Pdo\Mysql as PhMysql,
    Security as PhSecurity,
    Queue\Beanstalk
};
use Engine\{
    Config as EnConfig,
    Service\Locator as EnServiceLocator,
    Cache\Dummy as EnCacheDummy,
    Cache\System as EnCacheSystem,
    Db\Model\Annotations\Initializer as ModelAnnotationsInitializer,
    Exception as EnException,
    Api\Http\Request as EnRequest,
    Api\Http\Response as EnResponse,
    Api\Http\Response\Manager as EnResponseManager,
    Api\FractalSerializer as EnFractalSerializer
};
use Monolog\{
    Logger as MoLogger,
    Handler\RollbarHandler as MoRollbarHandler
};
use League\{
    Flysystem\Adapter\Local as FlyLocalAdapter,
    Flysystem\Filesystem as FlySystem,
    Fractal\Manager as FractalManager
};

/**
 * Application initialization trait.
 *
 * @category  ThePhalconPHP
 * @author    Nguyen Duc Duy <nguyenducduy.it@gmail.com>
 * @copyright 2016-2017
 * @license   New BSD License
 * @link      http://thephalconphp.com/
 */
trait Init
{
    /**
     * Init logger.
     *
     * @param DI     $di     Dependency Injection.
     * @param Config $config Config object.
     *
     * @return void
     */
    protected function _initLogger(DI $di, EnConfig $config)
    {
        $di->set('logger', function () use ($config) {
            // installs global error and exception handlers
            \Rollbar::init($config->default->rollbarClient->toArray());

            $logger = new MoLogger('main');
            $logger->pushHandler(new MoRollbarHandler(\Rollbar::$instance));

            return $logger;
        }, false);
    }

    /**
     * Init loader.
     *
     * @param DI            $di            Dependency Injection.
     * @param Config        $config        Config object.
     * @param EventsManager $eventsManager Event manager.
     *
     * @return Loader
     */
    protected function _initLoader(DI $di, EnConfig $config, PhEventsManager $eventsManager): PhLoader
    {
        /**
         * Add all required namespaces and modules from registry.
         *
         * @var [type]
         */
        $registry = $di->get('registry');
        $namespaces = [];
        $bootstraps = [];

        foreach ($registry->modules as $module) {
            $moduleName = ucfirst($module);
            $namespaces[$moduleName] = $registry->directories->modules . $moduleName;
            $bootstraps[$module] = $moduleName . '\Bootstrap';
        }

        $namespaces['Engine'] = $registry->directories->engine;

        $loader = new PhLoader();
        $loader->registerNamespaces($namespaces);
        $loader->registerDirs([
            ROOT_PATH . '/app/libs'
        ]);
        $loader->setEventsManager($eventsManager);
        $loader->register();
        $this->registerModules($bootstraps);

        $di->set('loader', $loader);

        return $loader;
    }

    /**
     * Init environment.
     *
     * @param DI     $di     Dependency Injection.
     * @param Config $config Config object.
     *
     * @return Url
     */
    protected function _initEnvironment(DI $di, EnConfig $config): PhUrl
    {
        set_error_handler(
            function ($errorCode, $errorMessage, $errorFile, $errorLine) {
                throw new \ErrorException($errorMessage, $errorCode, 1, $errorFile, $errorLine);
            }
        );

        set_exception_handler(
            function ($e) use ($di) {
                $di->get('response')->sendException($e);

                /**
                 * Write to log when app in production mode.
                 */
                if (ENV === 'production') {
                    $errorId = EnException::logException($e);
                }

                return true;
            }
        );

        /**
         * The URL component is used to generate all kind of urls in the
         * application
         */
        $url = new PhUrl();
        $baseUrl = $config->api->baseUrl;
        $url->setBaseUri($di->get('request')->getScheme() . '://' . $baseUrl . '/');
        $di->set('url', $url);

        return $url;
    }

    /**
     * Init engine.
     *
     * @param DI $di Dependency Injection.
     *
     * @return void
     */
    protected function _initEngine(DI $di)
    {
        foreach ($di->get('registry')->modules as $module) {
            $di->setShared(strtolower($module), function () use ($module, $di) {
                return new EnServiceLocator($module, $di);
            });
        }

        $di->setShared('transactions', function () {
            return new TxManager();
        });
    }

    /**
     * Init annotations.
     *
     * @param DI     $di     Dependency Injection.
     * @param Config $config Config object.
     *
     * @return void
     */
    protected function _initAnnotations(DI $di, EnConfig $config)
    {
        $di->set(
            'annotations',
            function () use ($config) {
                if (ENV === 'development') {
                    $adapter = new PhAnnotationsMemory();
                } else {
                    $annotationsAdapter = '\Phalcon\Annotations\Adapter\\' . $config->default->annotations->adapter;
                    $adapter = new $annotationsAdapter($config->default->annotations->toArray());
                }

                return $adapter;
            },
            true
        );
    }

    /**
     * Init Backend cache.
     *
     * @param DI     $di     Dependency Injection.
     * @param Config $config Config object.
     *
     * @return void
     */
    protected function _initCache(DI $di, EnConfig $config)
    {
        if (ENV === 'development') {
            // Create a dummy cache for system.
            // System will work correctly and the data will be always current for all adapters.
            $dummyCache = new EnCacheDummy(null);
            $di->set('viewCache', $dummyCache);
            $di->set('cacheOutput', $dummyCache);
            $di->set('cacheData', $dummyCache);
            $di->set('modelsCache', $dummyCache);
        } else {
            // Get the parameters.
            $cacheAdapter = '\Phalcon\Cache\Backend\\' . $config->default->cache->adapter;
            $frontEndOptions = ['lifetime' => $config->default->cache->lifetime];
            $backEndOptions = $config->default->cache->toArray();
            $frontOutputCache = new PhCacheOutput($frontEndOptions);
            $frontDataCache = new PhCacheData($frontEndOptions);

            $cacheOutputAdapter = new $cacheAdapter($frontOutputCache, $backEndOptions);
            $di->set('viewCache', $cacheOutputAdapter, true);
            $di->set('cacheOutput', $cacheOutputAdapter, true);

            $cacheDataAdapter = new $cacheAdapter($frontDataCache, $backEndOptions);
            $di->set('cacheData', $cacheDataAdapter, true);
            $di->set('modelsCache', $cacheDataAdapter, true);
        }
    }

    /**
     * Init MySQL database.
     *
     * @param DI            $di            Dependency Injection.
     * @param Config        $config        Config object.
     * @param EventsManager $eventsManager Event manager.
     *
     * @return Pdo
     */
    protected function _initDb(DI $di, EnConfig $config, PhEventsManager $eventsManager): PhMysql
    {
        /** @var Pdo $connection */
        $connection = new PhMysql([
            'host' => $config->db->mysql->host,
            'port' => $config->db->mysql->port,
            'username' => $config->db->mysql->username,
            'password' => $config->db->mysql->password,
            'dbname' => $config->db->mysql->dbname,
            'charset' => 'utf8',
            'persistent' => true
        ]);

        $di->set('db', $connection);
        $di->set(
            'modelsManager',
            function () use ($config, $eventsManager) {
                $modelsManager = new PhModelsManager();
                $modelsManager->setEventsManager($eventsManager);

                // Attach a listener to models-manager
                $eventsManager->attach('modelsManager', new ModelAnnotationsInitializer());

                return $modelsManager;
            },
            true
        );

        /**
         * If the configuration specify the use of metadata adapter use it or use memory otherwise.
         */
        $di->set(
            'modelsMetadata',
            function () use ($config) {
                if (ENV === 'development') {
                    $metaData = new PhMetadataMemory();
                } else {
                    $metaDataConfig = $config->default->metadata;
                    $metadataAdapter = '\Phalcon\Mvc\Model\Metadata\\' . $metaDataConfig->adapter;
                    $metaData = new $metadataAdapter($config->default->metadata->toArray());
                }

                $metaData->setStrategy(new PhStrategyAnnotations());

                return $metaData;
            },
            true
        );

        return $connection;
    }

    /**
     * Init router.
     *
     * @param DI     $di     Dependency Injection.
     * @param Config $config Config object.
     *
     * @return Router
     */
    protected function _initRouter(DI $di, Enconfig $config): PhRouter
    {
        $cacheData = $di->get('cacheData');
        $router = $cacheData->get(EnCacheSystem::CACHE_KEY_API_ROUTER_DATA);

        if ($router == null) {
            $saveToCache = ($router === null);

            // Load all controllers of all modules for routing system.
            $modules = $di->get('registry')->modules;

            // Use the annotations router.
            $router = new PhRouterAnnotations(false);


            /**
             * Load all route from router file
             */
            foreach ($modules as $module) {
                $moduleName = ucfirst($module);

                // Get all file names.
                $moduleDir = opendir($di->get('registry')->directories->modules . $moduleName . '/Handler');
                while ($file = readdir($moduleDir)) {
                    if (preg_match('/^[V]{1}[0-9]+/', $file)) {
                        $versionDir = array_diff(
                            scandir($di->get('registry')->directories->modules . $moduleName . '/Handler/' . $file),
                            array('..', '.')
                        );

                        foreach ($versionDir as $versionController) {
                            $controllerVersion = $moduleName . '\Handler\\' . $file . '\\' . str_replace('Controller.php', '', $versionController);
                            $router->addModuleResource(strtolower($module), $controllerVersion);
                        }
                    }

                    if ($file == "." || $file == ".." || strpos($file, 'Controller.php') === false) {
                        continue;
                    }
                }
                closedir($moduleDir);
            }

            if ($saveToCache) {
                $cacheData->save(EnCacheSystem::CACHE_KEY_API_ROUTER_DATA, $router, 2592000); // 30 days cache
            }
        }

        $router->removeExtraSlashes(true);

        $di->set('router', $router);

        return $router;
    }

    /**
     * Init file manager.
     *
     * @param DI $di Dependency Injection.
     *
     * @return void
     */
    protected function _initFile(DI $di)
    {
        $di->setShared('file', function() {
            $cache = null;
            $filesystem = new FlySystem(
                new FlyLocalAdapter(ROOT_PATH),
                $cache
            );

            return $filesystem;
        });
    }

    /**
     * Init security.
     *
     * @param DI     $di     Dependency Injection.
     *
     * @return void
     */
    protected function _initSecurity(DI $di)
    {
        $di->set('security', function () {
            $security = new PhSecurity();
            $security->setWorkFactor(10);

            return $security;
        });
    }

    /**
     * Init HTTP Response.
     *
     * @param DI     $di     Dependency Injection.
     * @param Config $config Config object.
     *
     * @return void
     */
    public function _initResponse(DI $di, EnConfig $config)
    {
        $di->set('response', function() use ($config) {
            $responseManager = new EnResponseManager($config->api->errorMessages->toArray());
            $response = new EnResponse();

            return $response->setManager($responseManager);
        }, true);
    }

    /**
     * Init HTTP Request.
     *
     * @param DI     $di     Dependency Injection.
     *
     * @return void
     */
    public function _initRequest(DI $di)
    {
        $di->set('request', function() {
            return new EnRequest();
        });
    }

    /**
     * Init fractal manager.
     *
     * @param DI $di Dependency Injection.
     *
     * @return void
     */
    protected function _initFractal(DI $di)
    {
        $di->setShared('fractal', function () {
            $fractal = new FractalManager();
            $fractal->setSerializer(new EnFractalSerializer());

            return $fractal;
        });
    }

    /**
     * Init Beanstalkd Queue.
     *
     * @param DI     $di     Dependency Injection.
     * @param Config $config Config object.
     *
     * @return void
     */
    protected function _initQueue(DI $di, EnConfig $config)
    {
        $di->set(
            'queue',
            function () use ($config) {
                $beanstalk = new Beanstalk([
                    'host'   => $config->db->queue->host,
                    'prefix' => $config->db->queue->prefix,
                    'persistent' => true
                ]);

                return $beanstalk;
            },
            true
        );
    }
}
