<?php
namespace Engine\Interfaces;

use Phalcon\{
    DI,
    DiInterface,
    Events\Manager as PhEventsManager
};

/**
 * Bootstrap interface.
 *
 * @category  ThePhalconPHP
 * @author    Nguyen Duc Duy <nguyenducduy.it@gmail.com>
 * @copyright 2016-2017
 * @license   New BSD License
 * @link      http://thephalconphp.com/
 */
interface BootstrapInterface
{
    /**
     * Create Bootstrap.
     *
     * @param DiInterface $di Dependency injection.
     * @param Manager     $em Events manager.
     */
    public function __construct(DI $di, PhEventsManager $em);

    /**
     * Register module services.
     *
     * @return void
     */
    public function registerServices();
}
