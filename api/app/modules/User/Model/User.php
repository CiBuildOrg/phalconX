<?php
namespace User\Model;

use Engine\{
    Db\AbstractModel,
    Behavior\Model\Imageable
};
use Phalcon\{
    Validation,
    Validation\Validator\PresenceOf,
    Validation\Validator\Uniqueness
};

/**
 * User Model.
 *
 * @category  ThePhalconPHP
 * @author    Nguyen Duc Duy <nguyenducduy.it@gmail.com>
 * @copyright 2016-2017
 * @license   New BSD License
 * @link      http://thephalconphp.com/
 *
 * @Source('fly_user');
 * @Behavior('\Engine\Behavior\Model\Timestampable');
 */
class User extends AbstractModel
{
    /**
    * @Primary
    * @Identity
    * @Column(type="integer", nullable=false, column="u_id")
    */
    public $id;

    /**
    * @Column(type="string", nullable=true, column="u_screenname")
    */
    public $screenname;

    /**
    * @Column(type="string", nullable=true, column="u_fullname")
    */
    public $fullname;

    /**
    * @Column(type="string", nullable=true, column="u_email")
    */
    public $email;

    /**
    * @Column(type="string", nullable=true, column="u_password")
    */
    public $password;

    /**
    * @Column(type="integer", nullable=true, column="u_groupid")
    */
    public $groupid;

    /**
    * @Column(type="integer", nullable=true, column="u_gender")
    */
    public $gender;

    /**
    * @Column(type="integer", nullable=true, column="u_region")
    */
    public $region;

    /**
    * @Column(type="string", nullable=true, column="u_avatar")
    */
    public $avatar;

    /**
    * @Column(type="integer", nullable=true, column="u_status")
    */
    public $status;

    /**
    * @Column(type="integer", nullable=true, column="u_oauth_uid")
    */
    public $oauthuid;

    /**
    * @Column(type="string", nullable=true, column="u_oauth_access_token")
    */
    public $oauthaccesstoken;

    /**
    * @Column(type="string", nullable=true, column="u_oauth_provider")
    */
    public $oauthprovider;

    /**
    * @Column(type="string", nullable=true, column="u_onesignal_id")
    */
    public $onesignalid;

    /**
    * @Column(type="integer", nullable=true, column="u_state")
    */
    public $state;

    /**
    * @Column(type="integer", nullable=true, column="u_datecreated")
    */
    public $datecreated;

    /**
    * @Column(type="integer", nullable=true, column="u_datemodified")
    */
    public $datemodified;

    const STATUS_ENABLE = 1;
    const STATUS_DISABLE = 3;
    const STATE_ONLINE = 1;
    const STATE_OFFLINE = 3;

    /**
     * Initialize model
     */
    public function initialize()
    {
        $config = $this->getDI()->get('config');

        $uploadPath = $config->default->user->directory . date('Y') . '/' . date('m');
        $this->addBehavior(new Imageable([
            'uploadPath' => $uploadPath,
            'sanitize' => $config->default->user->sanitize,
            'allowedFormats' => $config->default->user->mimes->toArray(),
            'allowedMinimumSize' => $config->default->user->minsize,
            'allowedMaximunSize' => $config->default->user->maxsize
        ]));
    }

    /**
     * Form field validation
     */
    public function validation()
    {
        $validator = new Validation();

        $validator->add('fullname', new PresenceOf(
            [
                'message' => 'message-fullname-notempty'
            ]
        ));

        $validator->add('groupid', new PresenceOf(
            [
                'message' => 'message-groupid-notempty'
            ]
        ));

        $validator->add('status', new PresenceOf(
            [
                'message' => 'message-status-notempty'
            ]
        ));

        return $this->validate($validator);
    }

    public function getStatusName(): string
    {
        $name = '';

        switch ($this->status) {
            case self::STATUS_ENABLE:
                $name = 'label-status-enable';
                break;
            case self::STATUS_DISABLE:
                $name = 'label-status-disable';
                break;
        }

        return $name;
    }

    public static function getStatusList()
    {
        return $data = [
            [
                'name' => 'label-status-enable',
                'value' => self::STATUS_ENABLE
            ],
            [
                'name' => 'label-status-disable',
                'value' => self::STATUS_DISABLE
            ],
        ];
    }

    public static function getStatusListArray()
    {
        return [
            self::STATUS_ENABLE,
            self::STATUS_DISABLE,

        ];
    }

    /**
     * return role constant hard code list from permission.php config file.
     * @return [array]
     */
    public static function getRoleList()
    {
        return [
            'Guest' => GROUP_GUEST,
            'Administrator' => GROUP_ADMIN,
            'Member' => GROUP_MEMBER
        ];
    }

    public function getRoleName(): string
    {
        $name = '';

        switch ($this->groupid) {
            case GROUP_ADMIN:
                $name = 'Administrator';
                break;
            case GROUP_MEMBER:
                $name = 'Member';
                break;
            case GROUP_GUEST:
                $name = 'Guest';
                break;
        }

        return $name;
    }

    /**
     * Get label style for status
     */
    public function getStatusStyle(): string
    {
        $class = '';
        switch ($this->status) {
            case self::STATUS_ENABLE:
                $class = 'label label-primary';
                break;
            case self::STATUS_DISABLE:
                $class = 'label label-danger';
                break;
        }

        return $class;
    }

    /**
     * Validate password
     */
    public function validatePassword($password): string
    {
        return $this->getDI()->get('security')->checkHash($password, $this->password);
    }

    // return avatar response support api
    public function getAvatarJson(): string
    {
        $path = '';

        if ($this->avatar != '') {
            $path = $this->getDI()->get('url')->getBaseUri() . ltrim($this->avatar, '/');
        }

        return $path;
    }
}
