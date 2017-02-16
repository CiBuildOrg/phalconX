<?php
namespace Api\Service;

use Engine\Service\Locator as EnServiceLocator;
use Phalcon\{
    Translate\Adapter\NativeArray as PhTranslateArray,
    Events\Event as PhEvent,
    Mvc\Dispatcher
};

/**
 * Core translate api.
 *
 * @category  Core
 * @author    Nguyen Duc Duy <nguyenducduy.it@gmail.com>
 * @copyright 2016-2017
 * @license   New BSD License
 * @link      http://thephalconphp.com/
 */
class Translator extends EnServiceLocator
{
    const DEFAULT_LANG_PACK = 'Api';

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
        $di = $this->getDI();
        $languageCode = '';

        // Localization
        $languageCode = strtolower($di->get('request')->getBestLanguage());
        if (!in_array($languageCode, $di->get('config')->default->supportedLocales->toArray())) {
            $languageCode = 'en-us';
        }

        $messages = [];
        $directory = $di->get('registry')->directories->modules . ucfirst($dispatcher->getModuleName()) . '/Locales/'
            . $languageCode . '/'
            . strtolower($dispatcher->getControllerName());
        $extension = '.php';

        if (file_exists($directory . $extension)) {
            require $directory . $extension;
        }

        // Load default language package
        require $di->get('registry')->directories->modules
            . self::DEFAULT_LANG_PACK
            . '/Locales/'
            . $languageCode
            . '/default.php';

        // added Default and Messages variables to translation service
        $translate = new PhTranslateArray([
            'content' => array_merge($messages, $default)
        ]);

        $di->set('lang', $translate);

        return !$event->isStopped();
    }
}
