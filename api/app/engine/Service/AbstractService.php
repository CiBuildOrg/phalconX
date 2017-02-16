<?php
namespace Engine\Service;

use Engine\{
    Behavior\DIBehavior,
    Interfaces\ServiceInterface
};
use Phalcon\{
    DI,
    DiInterface
};

/**
 * Abstract Service.
 *
 * @category  ThePhalconPHP
 * @author    Nguyen Duc Duy <nguyenducduy.it@gmail.com>
 * @copyright 2016-2017
 * @license   New BSD License
 * @link      http://thephalconphp.com/
 */
abstract class AbstractService implements ServiceInterface
{
    use DIBehavior {
        DIBehavior::__construct as protected __DIConstruct;
    }

    /**
     * Service arguments.
     *
     * @var array
     */
    private $_arguments;

    /**
     * Create Service.
     *
     * @param DiInterface $di        Dependency Service.
     * @param array       $arguments Service arguments.
     */
    public function __construct(DiInterface $di, $arguments)
    {
        $this->__DIConstruct($di);
        $this->_arguments = $arguments;
    }

    /**
     * Get Service call arguments.
     *
     * @return array
     */
    public function getArguments()
    {
        return $this->_arguments;
    }
}
