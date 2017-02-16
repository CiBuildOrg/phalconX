<?php
date_default_timezone_set('Asia/Bangkok');

/**
 * Default global configuration.
 */
return [
    'prefix' => '_phalconx_',
    'title' => 'phalconx - Development',
    'cookieEncryptionkey' => 'KkX+DVfEA>196yN',

    'supportedLocales' => [
        'en-us'
    ],

    'version' => [
        'css' => 1,
        'js' => 1
    ],

    'cache' => [
        'lifetime' => 86400,
        'adapter' => 'File',
        'cacheDir' => ROOT_PATH . '/app/var/cache/data/'
    ],

    'logger' => [
        'enabled' => false,
        'path' => ROOT_PATH . '/var/logs/',
        'format' => '[%date%][%type%] %message%'
    ],

    'session' => [
        'adapter' => 'Files'
    ],

    'assets' => [
        'local' => 'assets/'
    ],

    'metadata' => [
        'adapter' => 'Memory',
        'metaDataDir' => ROOT_PATH . '/app/var/cache/metadata/'
    ],

    'annotations' => [
        'adapter' => 'Memory',
        'annotationsDir' => ROOT_PATH . '/app/var/cache/annotations/'
    ],

    'rollbarClient' => [
        'access_token' => 'b26c4ef25f23473980231c855baaf65f',
        'environment' => 'production',
    ],

    'authentication' => [
        'genSalt' => 'should-also-be-in-application-env',
        'expireTime' => 86400 * 365, // 365 days till token expires
    ],

    'phpmailer' => [
        'debugMode' => 0, // 0 = off, 1 = client messages, 2 = client and server messages
        'host' => 'smtp.gmail.com',
        'port' => 587,
        'smtpSecure' => 'tls',
        'smtpAuth' => true,
        'from' => ['your-email-address', 'your-name'],
        'replyTo' => ['your-email-address', 'your-name'],
        'username' => 'your-email-address-or-username',
        'password' => 'your-password',
    ],

    'activationMail' => [
        'subject' => 'Activate your account',
        'template' => 'mail/activation', // in views folder
    ],

    'user' => [
        'directory' => '/public/uploads/avatar/',
        'minsize' => 1000, //1KB
        'maxsize' => 10000000, //10MB
        'mimes' => [
            'image/gif',
            'image/jpeg',
            'image/jpg',
            'image/png',
        ],
        'sanitize' => true,
        'isoverwrite' => false
    ],
];
