<?php

return [
    'namespace' => 'App\Http\Controllers',

    'routes' => [
        'web' => [

        ],
        'api' => [
            'standardsTree' => env('API_STANDARDS_TREE', 'x')
        ]
    ]
];