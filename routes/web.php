<?php

Route::group(
    [
        'namespace'  => 'Customer',
        'middleware' => 'customer',
    ],
    function () {
        Route::group(
            [
                'prefix' => 'product',
                'as'     => 'product::',
            ],
            function () {
                Route::get(
                    '{id}/{slug}',
                    [
                        'as'   => 'view',
                        'uses' => 'ProductController@viewAction',
                    ]
                );
            }
        );
        Route::group(
            [
                'prefix' => 'tag',
                'as'     => 'tag::',
            ],
            function () {
                Route::get(
                    '{id}/{name}',
                    [
                        'as'   => 'view',
                        'uses' => 'TagController@viewAction',
                    ]
                );
            }
        );
    }
);

Route::group(
    [
        'prefix'     => 'staff',
        'middleware' => [
            'auth',
            'staff',
        ],
    ],
    function () {
        Route::get(
            'dashboard',
            [
                'uses' => 'Staff\DashboardController@getIndex',
                'as'   => 'staff.dashboard',
            ]
        );
        Route::get('php-info', 'Staff\DashboardController@getPhpInfo');
    }
);

Route::group(
    [
        'namespace'  => 'Customer',
        'middleware' => 'customer',
    ],
    function () {
        Route::get(
            'cards',
            [
                'as'   => 'customer.cards',
                'uses' => 'CategoriesController@viewAction',
            ]
        );
        Route::get(
            '{path}',
            [
                'uses' => 'StaticController@pageAction',
                'as'   => 'customer.static',
            ]
        );
    }
);

Route::get(
    '/',
    [
        'uses'       => 'Customer\RootController@getIndex',
        'middleware' => 'customer',
    ]
);

Route::get('home', 'Customer\RootController@getIndex');