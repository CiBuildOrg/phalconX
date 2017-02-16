<?php

/**
 * Access Controll List (ACL) Config Variable
 * @var array
 */
define('GROUP_GUEST', 1);
define('GROUP_ADMIN', 5);
define('GROUP_MEMBER', 15);

return [
    'publicEndpoint' => [
        '/v1/user/login/email',
        // '/v1/user'
    ],

    'acl' => [
        GROUP_GUEST => [
            'User' => [
            ]
        ],

        GROUP_ADMIN => [
            'User' => [
                'v1:index|*',
            ]
        ],

        GROUP_MEMBER => [
            'User' => [
                'v1:index|logout',
                'v1:index|list',
            ],

        ],
    ]
];
