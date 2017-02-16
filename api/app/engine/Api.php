<?php
namespace Engine;

use Phalcon\{
    Mvc\Application as PhApp,
    DI\FactoryDefault as PhDi,
    Registry as PhRegistry,
    Events\Manager as PhEventsManager,
    Http\Response as PhResponse
};

/**
 * Api application class.
 *
 * @category  ThePhalconPHP
 * @author    Nguyen Duc Duy <nguyenducduy.it@gmail.com>
 * @copyright 2016-2017
 * @license   New BSD License
 * @link      http://thephalconphp.com/
 */
class Api extends PhApp
{
    use Api\Init;

    const
        /**
         * Default module.
         */
        SYSTEM_DEFAULT_MODULE = 'api';

    /**
     * Application configuration.
     *
     * @var Config
     */
    protected $_config;

    /**
     * Loaders for different modes.
     *
     * @var array
     */
    private $_loaders = [
        'normal' => [
            'request',
            'response',
            'environment',
            'engine',
            'annotations',
            'db',
            'cache',
            'router',
            'security',
            'file',
            'fractal',
            'queue',
        ]
    ];

    /**
     * Constructor.
     */
    public function __construct()
    {
        /**
         * Create default DI.
         */
        $di = new PhDi();

        /**
         * Get config.
         */
        $this->_config = Config::factory(ENV);

        /**
         * Adding modules to registry to load.
         * Module namespace - directory will be load from here.
         */
        $registry = new PhRegistry();
        $registry->modules = array_merge(
            [self::SYSTEM_DEFAULT_MODULE],
            $this->_config->loadmodule->toArray()
        );

        $registry->directories = (object) [
            'engine' => ROOT_PATH . '/app/engine/',
            'modules' => ROOT_PATH . '/app/modules/'
        ];
        $di->set('registry', $registry);

        /**
         * Store config in the DI container.
         */
        $di->setShared('config', $this->_config);

        parent::__construct($di);
    }

    /**
     * Runs the application, performing all initializations.
     *
     * @param string $mode Mode name.
     *
     * @return void
     */
    public function run(string $mode)
    {
        /**
         * Set application main objects.
         */
        $di = $this->_dependencyInjector;

        // set app service
        $di->setShared('app', $this);
        $config = $this->_config;
        $eventsManager = new PhEventsManager();
        $this->setEventsManager($eventsManager);

        /**
         * Init base systems first.
         */
        $this->_initLogger($di, $config, $eventsManager);
        $this->_initLoader($di, $config, $eventsManager);

        /**
         * Init services and engine system.
         */
        foreach ($this->_loaders[$mode] as $service) {
            $serviceName = ucfirst($service);
            $eventsManager->fire('init:before' . $serviceName, null);
            $result = $this->{'_init' . $serviceName}($di, $config, $eventsManager);
            $eventsManager->fire('init:after' . $serviceName, $result);
        }

        $di->setShared('eventsManager', $eventsManager);
    }

    /**
     * Get application output.
     *
     * @return string
     */
    public function getOutput()
    {
        echo $this->handle()->getContent();
    }

    /**
     * Init modules and register them. (Call from _initLoader)
     *
     * @param array $modules Modules bootstrap classes.
     * @param null  $merge   Merge with existing.
     *
     * @return $this
     */
    public function registerModules(array $modules, $merge = null): PhApp
    {
        $bootstraps = [];
        $di = $this->getDI();

        foreach ($modules as $moduleName => $moduleClass) {
            if (isset($this->_modules[$moduleName])) {
                continue;
            }

            $bootstrap = new $moduleClass($di, $this->getEventsManager());
            $bootstraps[$moduleName] = function () use ($bootstrap, $di) {
                $bootstrap->registerServices();

                return $bootstrap;
            };
        }

        return parent::registerModules($bootstraps, $merge);
    }
}
