<?php
namespace User\Handler\V1;

use Api\Handler\AbstractController;
use Engine\{
    Api\Exception\UserException,
    Api\Constants\ErrorCode
};
use User\{
    Model\User as UserModel,
    Transformer\User as UserTransformer
};

/**
 * User api.
 *
 * @category  ThePhalconPHP
 * @author    Nguyen Duc Duy <nguyenducduy.it@gmail.com>
 * @copyright 2014-2015
 * @license   New BSD License
 * @link      http://thephalconphp.com/
 *
 * @RoutePrefix("/v1/user")
 */
class IndexController extends AbstractController
{
    protected $recordPerPage = 10;

    /**
     * Return all user in system
     *
     * @return void
     *
     * @Route("/", methods={"GET"})
     */
    public function listAction()
    {
        $page = (int) $this->request->getQuery('page', null, 1);
        $formData = [];
        $hasMore = true;

        // Search keyword in specified field model
        $searchKeywordInData = [
        ];
        $page = (int) $this->request->getQuery('page', null, 1);
        $orderBy = (string) $this->request->getQuery('orderby', null, 'id');
        $orderType = (string) $this->request->getQuery('ordertype', null, 'desc');
        $keyword = (string) $this->request->getQuery('keyword', null, '');
        // optional Filter
        $uid1 = (int) $this->request->getQuery('uid1', null, 0);
        $uid2 = (int) $this->request->getQuery('uid2', null, 0);
        $formData['columns'] = '*';
        $formData['conditions'] = [
            'keyword' => $keyword,
            'searchKeywordIn' => $searchKeywordInData,
            'filterBy' => [
                'uid1' => $uid1,
                'uid2' => $uid2
            ]
        ];
        $formData['orderBy'] = $orderBy;
        $formData['orderType'] = $orderType;

        $myUsers = UserModel::paginate($formData, $this->recordPerPage, $page, true, 120);

        if ($myUsers->total_pages > 0) {
            if ($page == $myUsers->total_pages) {
                $hasMore = false;
            }

            return $this->createCollection(
                $myUsers->items,
                new UserTransformer,
                'records',
                [
                    'meta' => [
                        'recordPerPage' => $this->recordPerPage,
                        'nextPage' => $page + 1,
                        'hasMore' => $hasMore
                    ]
                ]
            );
        } else {
            return $this->respondWithArray([], 'records');
        }
    }

    /**
     * Login user action.
     *
     * @return void
     *
     * @Route("/login/{account:[a-z]{1,10}}", methods={"POST"})
     */
    public function loginAction($account)
    {
        $formData = (array) $this->request->getJsonRawBody();
        $email = (string) $formData['email'];
        $password = (string) $formData['password'];

        if (strlen($email) == 0) {
            throw new UserException(ErrorCode::AUTH_NOEMAIL);
        };

        if (strlen($password) == 0) {
            throw new UserException(ErrorCode::AUTH_NOPASSWORD);
        };

        if (!$this->auth->login($account, $email, $password)) {
            throw new UserException(ErrorCode::AUTH_BADLOGIN, 'Failed to login.');
        }

        // Generate jwt authToken for valid user.
        $tokenResponse = $this->auth->getTokenResponse();

        return $this->respondWithArray($tokenResponse, 'response');
    }

    /**
     * Logout user action.
     *
     * @return void
     *
     * @Route("/logout/{account:[a-z]{1,10}}", methods={"PUT"})
     */
    public function logoutAction($account)
    {
        $logout = true;
        $id = (int) $this->getDI()->get('auth')->getUser()->id;

        $myUser = UserModel::findFirst([
            'id = :id:',
            'bind' => [
                'id' => $id
            ]
        ]);

        if (!$myUser) {
            throw new UserException(ErrorCode::DATA_NOTFOUND);
        }

        // More secure if decided logout on the devices registered

        // Check user already logged out
        if ($myUser->status == UserModel::STATUS_DISABLE) {
            throw new UserException(ErrorCode::DATA_REJECTED);
        }

        $myUser->status = UserModel::STATUS_DISABLE;
        // change state to offline
        $myUser->state = UserModel::STATE_OFFLINE;
        if (!$myUser->update()) {
            throw new UserException(ErrorCode::DATA_UPDATE_FAIL);
        }

        return $this->respondWithArray([
            'id' => (int) $myUser->id,
            'logout' => (bool) $logout
        ], 'results');
    }
}
