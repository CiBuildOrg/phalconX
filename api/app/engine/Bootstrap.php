<?php
namespace Engine;

use Phalcon\{
    DI,
    DiInterface,
    Events\Manager as PhEventsManager
};
use Engine\{
    Interfaces\BootstrapInterface,
    Plugin\DispatchErrorHandler,
    Behavior\DIBehavior,
    Dispatcher as EnDispatcher,
    View as EnView
};

/**
 * Bootstrap class.
 *
 * @category  ThePhalconPHP
 * @author    Nguyen Duc Duy <nguyenducduy.it@gmail.com>
 * @copyright 2016-2017
 * @license   New BSD License
 * @link      http://thephalconphp.com/
 */
abstract class Bootstrap implements BootstrapInterface
{
    use DIBehavior {
        DIBehavior::__construct as protected __DIConstruct;
    }

    /**
     * Module name.
     *
     * @var string
     */
    protected $_moduleName = "";

    /**
     * Configuration.
     *
     * @var PhalconConfig
     */
    private $_config;

    /**
     * Events manager.
     *
     * @var Manager
     */
    private $_em;

    /**
     * Create Bootstrap.
     *
     * @param DiInterface $di Dependency injection.
     * @param Manager     $em Events manager.
     */
    public function __construct(DI $di, PhEventsManager $em)
    {
        $this->__DIConstruct($di);
        $this->_em = $em;
        $this->_config = $this->getDI()->get('config');
    }

    /**
     * Register the services.
     *
     * @throws Exception
     * @return void
     */
    public function registerServices()
    {
        if (empty($this->_moduleName)) {
            $class = new \ReflectionClass($this);
            throw new \Exception('Bootstrap has no module name: ' . $class->getFileName());
        }

        $di = $this->getDI();
        $config = $this->getConfig();
        $eventsManager = $this->getEventsManager();
        $moduleDirectory = $this->getModuleDirectory();

        /*************************************************/
        //  Initialize view.
        /*************************************************/
        $di->set(
            'view',
            function () use ($di, $config, $moduleDirectory, $eventsManager) {
                return Api\View::factory($di, $config, $moduleDirectory . '/View/', $eventsManager);
            }
        );

        /*************************************************/
        //  Initialize dispatcher.
        /*************************************************/
        $eventsManager->attach('dispatch:beforeException', new DispatchErrorHandler());

        // Create dispatcher.
        $dispatcher = new EnDispatcher();
        $dispatcher->setEventsManager($eventsManager);
        $di->set('dispatcher', $dispatcher);
    }

    /**
     * Get current module directory.
     *
     * @return string
     */
    public function getModuleDirectory()
    {
        return $this->getDI()->get('registry')->directories->modules . $this->_moduleName;
    }

    /**
     * Get config object.
     *
     * @return mixed|PhalconConfig
     */
    public function getConfig()
    {
        return $this->_config;
    }

    /**
     * Get events manager.
     *
     * @return Manager
     */
    public function getEventsManager()
    {
        return $this->_em;
    }

    /**
     * Get current module name.
     *
     * @return string
     */
    public function getModuleName()
    {
        return $this->_moduleName;
    }
}
