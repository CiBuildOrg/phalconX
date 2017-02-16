<?php
namespace Engine\Api;

use Phalcon\DI;
use Phalcon\Events\Manager;
use Phalcon\Mvc\View as PhView;

/**
 * Api View factory.
 *
 * @category  ThePhalconPHP
 * @author    Nguyen Duc Duy <nguyenducduy.it@gmail.com>
 * @copyright 2014-2015
 * @license   New BSD License
 * @link      http://thephalconphp.com/
 */
class View extends PhView
{
    /**
     * Create view instance.
     * If no events manager provided - events would not be attached.
     *
     * @param DIBehaviour  $di             DI.
     * @param Config       $config         Configuration.
     * @param string       $viewsDirectory Views directory location.
     * @param Manager|null $em             Events manager.
     *
     * @return View
     */
    public static function factory($di, $config, $viewsDirectory, $em = null)
    {
        $view = new PhView();
        $view->disable();
        $di->set('view', $view);

        return $view;
    }
}
