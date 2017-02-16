<?php
namespace Core;

use Phalcon\{
    DI,
    DiInterface,
    Events\Manager as PhEventsManager
};
use Engine\{
    Bootstrap as EnBootstrap
};

/**
 * Core Bootstrap.
 *
 * @category  ThePhalconPHP
 * @author    Nguyen Duc Duy <nguyenducduy.it@gmail.com>
 * @copyright 2016-2017
 * @license   New BSD License
 * @link      http://thephalconphp.com/
 */
class Bootstrap extends EnBootstrap
{
    /**
     * Current module name.
     *
     * @var string
     */
    protected $_moduleName = 'Core';

    /**
     * Bootstrap construction.
     *
     * @param DiInterface $di Dependency injection.
     * @param Manager     $em Events manager object.
     */
    public function __construct(DI $di, PhEventsManager $em)
    {
        parent::__construct($di, $em);

        /**
         * Attach this bootstrap for all application initialization events.
         */
        $em->attach('init', $this);
    }

    /**
     * Init some subsystems after engine initialization.
     */
    public function afterEngine()
    {
        $di = $this->getDI();
    }
}
