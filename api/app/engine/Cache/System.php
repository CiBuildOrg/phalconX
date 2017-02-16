<?php
namespace Engine\Cache;

use Phalcon\Cache\Backend;

/**
 * System cache keys.
 *
 * @category  ThePhalconPHP
 * @author    Nguyen Duc Duy <nguyenducduy.it@gmail.com>
 * @copyright 2016-2017
 * @license   New BSD License
 * @link      http://thephalconphp.com/
 *
 */
class System
{
    const CACHE_KEY_ROUTER_DATA = 'router.cache';
    const CACHE_KEY_API_ROUTER_DATA = 'api.router.cache';
}
