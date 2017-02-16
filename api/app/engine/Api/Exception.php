<?php
namespace Engine\Api;

/**
 * Api system exception.
 *
 * @category  ThePhalconPHP
 * @author    Nguyen Duc Duy <nguyenducduy.it@gmail.com>
 * @copyright 2014-2015
 * @license   New BSD License
 * @link      http://thephalconphp.com/
 */
class Exception extends \Exception
{
    public function __construct($code, $message = null)
    {
        $this->code = $code;
        $this->message = $message;
    }
}
