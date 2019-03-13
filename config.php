<?php
return [
    'db' => [
        'username' => '%db.user%',
        'password' => '%db.password%',
        'dbname' => '%db.database%',
        'host' => '%db.host%',
        'port' => '%db.port%'
    ],
    'csrfProtection' => [
        'frontend' => false,
        'backend' => false
    ],
    'phpsettings' => [
        'error_reporting' => E_ALL & ~E_USER_DEPRECATED,
        'display_errors' => 1,
        'date.timezone' => 'Europe/Berlin',
    ],
    'snippet' => [
        'readFromDb' => true,
        'writeToDb' => true,
        'readFromIni' => false,
        'writeToIni' => false,
        'showSnippetPlaceholder' => true,
    ],
    'mail' => array(
        'type' => 'smtp',
        'host' => 'localhost',
        'port' => 1025,
    ),
    'front' => [
        'noErrorHandler' => true,
        'throwExceptions' => true,
        'showException' => true
    ],
    'httpcache' => [
        'enabled' => true,
        'debug' => true,
        'default_ttl' => 0,
        'private_headers' => ['Authorization', 'Cookie'],
        'allow_reload' => false,
        'allow_revalidate' => false,
        'stale_while_revalidate' => 2,
        'stale_if_error' => false,
        'cache_cookies' => ['shop', 'currency', 'x-cache-context-hash'],
    ],
    'trustedProxies' => ['127.0.0.1'],
    'template' => [
        'forceCompile' => true,
    ],
    'session' => [
        'locking' => false
    ]
];
