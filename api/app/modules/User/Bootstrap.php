<?php
namespace User;

use Phalcon\{
    DI,
    DiInterface,
    Events\Manager as PhEventsManager
};
use Engine\Bootstrap as EnBootstrap;

/**
 * User Bootstrap.
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
    protected $_moduleName = 'User';

    /**
     * Bootstrap construction.
     *
     * @param DiInterface $di Dependency injection.
     * @param Manager     $em Events manager object.
     */
    public function __construct(DI $di, PhEventsManager $em)
    {
        parent::__construct($di, $em);
    }
}
