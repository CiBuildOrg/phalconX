<?php

namespace Engine\Api\Constants;

/**
 * Define constants.
 *
 * @category  ThePhalconPHP
 * @author    Nguyen Duc Duy <nguyenducduy.it@gmail.com>
 * @copyright 2014-2015
 * @license   New BSD License
 * @link      http://thephalconphp.com/
 */
class ErrorCode
{
    // General
    const GENERAL_NOTFOUND = 1001;
    const GENERAL_SERVER_ERROR = 1002;

    // Data
    const DATA_DUPLICATE = 2001;
    const DATA_NOTFOUND = 2002;
    const DATA_INVALID = 2004;
    const DATA_FAIL = 2005;

    const DATA_FIND_FAIL = 2010;
    const DATA_CREATE_FAIL = 2020;
    const DATA_UPDATE_FAIL = 2030;
    const DATA_DELETE_FAIL = 2040;
    const DATA_REJECTED = 2060;
    const DATA_NOTALLOWED = 2070;

    // Authentication
    const AUTH_NOEMAIL = 3007;
    const AUTH_INVALIDTYPE = 3008;
    const AUTH_BADLOGIN = 3009;
    const AUTH_UNAUTHORIZED = 3010;
    const AUTH_NOPASSWORD = 3011;
    const AUTH_NOTOKEN = 3012;
    const AUTH_FORBIDDEN = 3020;
    const AUTH_EXPIRED = 3030;

    // Google
    const GOOGLE_NODATA = 4001;
    const GOOGLE_BADLOGIN = 4002;

    // User management
    const USER_NOTACTIVE = 4003;
    const USER_NOTFOUND = 4004;
    const USER_REGISTERFAIL = 4005;
    const USER_MODFAIL = 4006;
    const USER_CREATEFAIL = 4007;
    const USER_REG_NOFULLNAME = 4008;
    const USER_REG_NOEMAIL = 4009;
    const USER_REG_NOPASSWORD = 4010;
    const USER_REG_UNUNIQUEEMAIL = 4011;
    const USER_REG_INVALIDEMAIL = 4012;

    // PDO
    const PDO_DUPLICATE_ENTRY = 2300;
}
