<?php
namespace User\Transformer;

use League\Fractal\TransformerAbstract;
use User\Model\User as UserModel;

/**
 * User Transformer.
 *
 * @category  ThePhalconPHP
 * @author    Nguyen Duc Duy <nguyenducduy.it@gmail.com>
 * @copyright 2014-2015
 * @license   New BSD License
 * @link      http://thephalconphp.com/
 */
class User extends TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
    ];

    /**
     * Turn this resource object into a generic array
     *
     * @return array
     */
    public function transform(UserModel $user)
    {
        return [
            'id' => (int) $user->id,
            'fullname' => (string) $user->fullname,
            'email' => (string) $user->email,
            'avatar' => (string) $user->getAvatarJson(),
            'datecreated' => (int) $user->datecreated,
            'humandatecreated' => (string) 'Tham gia ngày ' . date('j/n/Y', $user->datecreated)
        ];
    }
}
