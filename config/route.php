<?php

return [
    'namespace' => 'App\Http\Controllers',

    'routes' => [
        'web' => [

        ],
        'api' => [
            // 前端
            'frontend' => [
                'standardsTree' => env('FRONTEND_API_STANDARDS_TREE', 'x'),
                'subtype' => env('FRONTEND_API_SUBTYPE', ''),
                'version' => env('FRONTEND_API_VERSION', 'v1'),
                'prefix' => env('FRONTEND_API_PREFIX', null),
                'domain' => env('FRONTEND_API_DOMAIN', null),
                'name' => env('FRONTEND_API_NAME', null),
                'defaultFormat' => env('FRONTEND_API_DEFAULT_FORMAT', 'json'),
                'routePath' => env('FRONTEND_API_ROUTE_PATH', 'routes/')
            ],
        ]
    ]
];