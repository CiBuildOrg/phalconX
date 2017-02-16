<?php
namespace User\Plugin\Account;

use Phalcon\Mvc\User\Plugin as PhPlugin;
use Engine\{
    Api\Constants\ErrorCode,
    Api\Exception\UserException
};
use User\Plugin\AccountInterface;
use User\Model\User as UserModel;

class Email extends PhPlugin implements AccountInterface
{
    public function __construct($name)
    {
        $this->name = $name;
    }

    public function login($email = null, $password = null)
    {
        $emailAccount = UserModel::findFirstByEmail($email);

        // Check if password is valid
        if (!$emailAccount || !$emailAccount->validatePassword($password)) {
            return false;
        }

        // Something is terribly wrong, can't find the real user
        if (!$user = $emailAccount) {
            return false;
        }

        return $user;
    }
}
