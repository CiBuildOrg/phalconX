<?php
namespace Api\Service;

use Phalcon\{
    Events\Event as PhEvent,
    Mvc\Dispatcher
};
use Engine\Service\Locator as EnServiceLocator;

class Fractalinclude extends EnServiceLocator
{
    public function beforeExecuteRoute(PhEvent $event, Dispatcher $dispatcher)
    {
        $include = $this->getDI()->get('request')->getQuery('include');

        if (!is_null($include)) {
            $this->getDI()->get('fractal')->parseIncludes($include);
        }
    }
}
