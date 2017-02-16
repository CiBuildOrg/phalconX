<?php
namespace Api\Service;

use Phalcon\{
    Events\Event as PhEvent,
    Mvc\Dispatcher
};
use Engine\Service\Locator as EnServiceLocator;

class Request extends EnServiceLocator
{
    /**
     * Triggered before executing the controller/action method.
     *
     * @param PhalconEvent $event      Event object.
     * @param Dispatcher   $dispatcher Dispatcher object.
     *
     * @return mixed
     */
    public function beforeExecuteRoute(PhEvent $event, Dispatcher $dispatcher)
    {
        // OPTIONS have no body, send the headers, exit
        if ($this->getDI()->get('request')->getMethod() == 'OPTIONS') {

            $this->getDI()->get('response')->send([
                'result' => 'OK',
            ]);
            exit;
        }
    }
}
