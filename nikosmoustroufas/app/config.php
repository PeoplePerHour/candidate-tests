<?php

declare(strict_types=1);

/*
Most of these can be set as ENV parameters, as well, but easier and faster if in PHP directly
*/
$basePath = dirname(dirname(__FILE__));
return [
    'baseurl'   => 'http://127.0.0.1:8000',
    'basepath'  => $basePath,
    'webroot'   => $basePath . '/webroot',
    'providers' => [
        'weatherbit'     => [
            'key' => '80bd8858c1e4469ca75087dabcccca06',
        ],
        'openweathermap' => [
            'key' => '8918b67167de2f5c4b66c00ae5f195e8',
        ],
    ],
    'cache'     => [
        'prefix'    => 'weather_',
        'cacheType' => 'FILE', /*or 'REDIS'*/
        'FILE'      => [
            'cacheDir' => $basePath . '/var/cache',
        ],
        'REDIS'     => [
            'server' => ['host' => '127.0.0.1', 'port' => 6379],
        ],
    ],
];
