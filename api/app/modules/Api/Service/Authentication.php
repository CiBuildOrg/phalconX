<?php
namespace Api\Service;

use Phalcon\{
    Events\Event as PhEvent,
    Mvc\Dispatcher
};
use Engine\Service\Locator as EnServiceLocator;

/**
 * Request authentication api.
 *
 * @category  ThePhalconPHP
 * @author    Nguyen Duc Duy <nguyenducduy.it@gmail.com>
 * @copyright 2014-2015
 * @license   New BSD License
 * @link      http://thephalconphp.com/
 */
class Authentication extends EnServiceLocator
{
    /**
     * This action is executed before execute any action in the application.
     *
     * @param PhalconEvent $event      Event object.
     * @param Dispatcher   $dispatcher Dispatcher object.
     *
     * @return mixed
     */
    public function beforeDispatch(PhEvent $event, Dispatcher $dispatcher)
    {
        $request = $this->getDI()->get('request');
        $authManager = $this->getDI()->get('auth');

        $token = $request->getToken();

        if ($token) {
            $authManager->authenticateToken($token);
        }
    }
}
