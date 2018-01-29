<?php

return [
    'database' => [
        'driver'       => 'mysql',
        'host'         => 'localhost',
        'port'         => 3306,
        'username'     => 'homestead',
        'password'     => 'secret',
        'database'     => 'candidate_tests',
        'charset'      => 'utf8mb4',
        'extraOptions' => [
            \PDO::ATTR_EMULATE_PREPARES => false,
        ],
    ],
    'cache'    => [
        'type'       => \PPH\CacheManager::CACHE_TYPE_FILESYSTEM,
        'path'       => __DIR__ . DIRECTORY_SEPARATOR . 'cache',
        'expiration' => 300,
    ],
];