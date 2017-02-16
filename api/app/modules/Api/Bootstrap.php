<?php
namespace Api;

use Phalcon\{
    DI,
    DiInterface,
    Events\Manager as PhEventsManager
};
use Engine\{
    Bootstrap as EnBootstrap,
    Api\Session\JWT as EnJWT,
    Api\Constants\AccountType as EnAccountType
};
use Firebase\JWT\JWT as FirebaseJWT;
use User\{
    Plugin\Account\Email as UserEmailAccount,
    Plugin\AuthManager as UserAuthManager
};

/**
 * Api Bootstrap.
 *
 * @category  ThePhalconPHP
 * @author    Nguyen Duc Duy <nguyenducduy.it@gmail.com>
 * @copyright 2016-2017
 * @license   New BSD License
 * @link      http://thephalconphp.com/
 */
class Bootstrap extends EnBootstrap
{
    /**
     * Current module name.
     *
     * @var string
     */
    protected $_moduleName = 'Api';

    /**
     * Bootstrap construction.
     *
     * @param DiInterface $di Dependency injection.
     * @param Manager     $em Events manager object.
     */
    public function __construct(DI $di, PhEventsManager $em)
    {
        parent::__construct($di, $em);

        $di->setShared('auth', function() use($di) {
            $sessionManager = new EnJWT(new FirebaseJWT());
            $authManager = new UserAuthManager($sessionManager);

            // Setup Account Type
            // -----------------------------------

            // 1. Instantiate Account Type
            $authEmail = new UserEmailAccount(EnAccountType::EMAIL);

            $authManager->setGenSalt($di->get('config')->default->authentication->genSalt);

            return $authManager
                ->addAccount(EnAccountType::EMAIL, $authEmail)
                ->setExpireTime($di->get('config')->default->authentication->expireTime);
        });

        /**
         * Attach this bootstrap for all application initialization events.
         */
        $em->attach('init', $this);
    }

    /**
     * Init some subsystems after engine initialization.
     */
    public function afterEngine()
    {
        $di = $this->getDI();

        $this->getEventsManager()->attach('dispatch', $di->get('api')->translator());
        $this->getEventsManager()->attach('dispatch', $di->get('api')->request());
        $this->getEventsManager()->attach('dispatch', $di->get('api')->fractalinclude());
        $this->getEventsManager()->attach('dispatch', $di->get('api')->authentication());
        $this->getEventsManager()->attach('dispatch', $di->get('api')->authorization());
    }
}
