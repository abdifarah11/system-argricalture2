<?php


return [
    [
        'title' => 'Dashboard',
        'icon' => 'bi-speedometer',
        'route' => 'dashboard',
    ],
    [
        'title' => 'Users',
        'icon' => 'bi-people-fill',
        'route' => 'users.index',
        'can' => 'admin',
    ],
    [
        'title' => 'Crops',
        'icon' => 'bi-flower1',
        'route' => 'crops.index',
    ],
    [
        'title' => 'Management',
        'icon' => 'bi-gear-fill',
        'children' => [
            [
                'title' => 'Crop Types',
                'icon' => 'bi-tags-fill',
                'route' => 'crop_types.index',
            ],
            [
                'title' => 'Transactions',
                'icon' => 'bi-currency-exchange',
                'route' => 'transactions.index',
            ],
        ],
    ],
];
