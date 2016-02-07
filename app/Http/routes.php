<?php

Route::group(['middleware' => ['web']], function () {

    Route::group(
        [
            'prefix'     => 'product',
            'as'         => 'product::',
            'namespace'  => 'Customer',
            'middleware' => 'customer',
        ],
        function () {
            Route::get('{id}/{slug}', [
                'as'   => 'view',
                'uses' => 'ProductController@viewAction'
            ]);
        }
    );

    Route::group(
        [
            'prefix'    => 'auth',
            'as'        => 'auth::',
            'namespace' => 'Auth',
        ],
        function () {
            Route::get('login', [
                'as'   => 'login',
                'uses' => 'AuthController@getLogin',
            ]);
            Route::post('login', [
                'as'   => 'login.post',
                'uses' => 'AuthController@postLogin',
            ]);
            Route::get('logout', [
                'as'   => 'logout',
                'uses' => 'AuthController@getLogout',
            ]);
        }
    );

    Route::group(
        [
            'prefix'     => 'staff',
            'middleware' => [
                'auth',
                'staff',
            ]
        ],
        function () {
            Route::get('dashboard', [
                'uses' => 'Staff\DashboardController@getIndex',
                'as'   => 'staff.dashboard'
            ]);
            Route::resource('products', 'Staff\ProductController');
            Route::get('php-info', 'Staff\DashboardController@getPhpInfo');
        }
    );

    Route::get('/', [
        'uses'       => 'Customer\RootController@getIndex',
        'middleware' => 'customer'
    ]);

    Route::get('/home', 'Customer\RootController@getIndex');

    Route::get('{path}', [
        'uses' => 'Customer\StaticController@pageAction',
        'as'   => 'customer.static'
    ]);

});
