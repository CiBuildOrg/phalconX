<?php
namespace Engine\Interfaces;

use Phalcon\DiInterface;

/**
 * Service interface.
 *
 * @category  ThePhalconPHP
 * @author    Nguyen Duc Duy <nguyenducduy.it@gmail.com>
 * @copyright 2016-2017
 * @license   New BSD License
 * @link      http://thephalconphp.com/
 */
interface ServiceInterface
{
    /**
     * Create api.
     *
     * @param DiInterface $di        Dependency Service.
     * @param array       $arguments Api arguments.
     */
    public function __construct(DiInterface $di, $arguments);
}
