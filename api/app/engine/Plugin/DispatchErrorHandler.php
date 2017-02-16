<?php
namespace Engine\Plugin;

use Phalcon\{
    Events\Event as PhEvent,
    Mvc\Dispatcher as PhDispatcher,
    Mvc\Dispatcher\Exception as PhDispatchException,
    Mvc\User\Plugin as PhUserPlugin
};

/**
 * Not found plugin.
 * @category  ThePhalconPHP
 * @author    Nguyen Duc Duy <nguyenducduy.it@gmail.com>
 * @copyright 2016-2017
 * @license   New BSD License
 * @link      http://thephalconphp.com/
 */
class DispatchErrorHandler extends PhUserPlugin
{
    /**
     * Before exception is happening.
     *
     * @param Event            $event      Event object.
     * @param Dispatcher       $dispatcher Dispatcher object.
     * @param PhalconException $exception  Exception object.
     *
     * @throws \Phalcon\Exception
     * @return bool
     */
    public function beforeException(PhEvent $event, PhDispatcher $dispatcher, $exception)
    {

    }
}
