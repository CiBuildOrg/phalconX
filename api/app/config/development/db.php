<?php
return [
    /**
 	 * MySQL config parameters
	 */
    'mysql' => [
        'adapter' => 'Mysql',
        'host' => 'localhost',
        'port' => '3306',
        'username' => 'root',
        'password' => 'root',
        'dbname' => 'kozoom',
    ],
    'memcached' => [
        [
            'host' => 'localhost',
            'port' => 11211,
            'weight' => '1'
        ]
    ],
    'queue' => [
        'host' => 'localhost',
        'port' => 11300,
        'prefix' => '_thephalconphp_'
    ],
    'neo4j' => [
        'host' => 'localhost',
        'port' => 7474,
        'username' => 'neo4j',
        'password' => '511011'
    ],
    'sphinx' => [
        'host' => 'localhost',
        'realtime_port' => 9306,
        'plain_port' => 9312,
        'maxMatches' => 1000,
        'index' => [
            'global' => 'global',
            'photo' => 'photo',
            'video' => 'video',
            'user' => 'user',
        ]
    ]
];
