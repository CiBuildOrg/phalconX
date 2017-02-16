<?php
namespace Engine\Api\Http;

use Phalcon\Http\Request as PhRequest;

/**
 * Engine Api HTTP Request.
 *
 * @category  ThePhalconPHP
 * @author    Nguyen Duc Duy <nguyenducduy.it@gmail.com>
 * @copyright 2014-2015
 * @license   New BSD License
 * @link      http://thephalconphp.com/
 */
class Request extends PhRequest
{
    protected function removeBearer($string)
    {
        return preg_replace('/.*\s/', '', $string);
    }

    public function getToken()
    {
        $authHeader = $this->getHeader('Authorization');
        $authQuery = $this->getQuery('token');

        return ($authQuery ? $authQuery : $this->removeBearer($authHeader));
    }
}
