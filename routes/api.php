<?php

Route::namespace('Api\V1')
    ->prefix('v1')
    ->name('api.v1.')
    ->middleware(['cors'])
    ->group(
        function () {
            Route::post('/auth/login', 'AuthController@login')->name('auth.login');
            Route::post('/auth/logout', 'AuthController@logout')->name('auth.logout');
            Route::post('/auth/register', 'AuthController@register')->name('auth.register');

            Route::middleware(['jwt'])->group(
                function () {
                    Route::resource('users', 'UserController');
                    Route::get('/user/me', 'UserController@me')->name('user.me');
                }
            );
        }
    );
