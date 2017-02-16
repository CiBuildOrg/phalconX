<?php
namespace Engine;

use Phalcon\Mvc\Dispatcher as PhDispatcher;

/**
 * Application dispatcher.
 *
 * @category  ThePhalconPHP
 * @author    Nguyen Duc Duy <nguyenducduy.it@gmail.com>
 * @copyright 2016-2017
 * @license   New BSD License
 * @link      http://thephalconphp.com/
 */
class Dispatcher extends PhDispatcher
{
    /**
     * Dispatch.
     * Override it to use own logic.
     *
     * @throws \Exception
     * @return object
     */
    public function dispatch()
    {
        try {
            $parts = explode('_', $this->_handlerName);
            $finalHandlerName = '';

            foreach ($parts as $part) {
                $finalHandlerName .= ucfirst($part);
            }
            $this->_handlerName = $finalHandlerName;
            $this->_actionName = strtolower($this->_actionName);

            return parent::dispatch();
        } catch (\Exception $e) {
            $this->_handleException($e);
        }

        return parent::dispatch();
    }
}
