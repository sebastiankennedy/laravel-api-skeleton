<?php

Route::namespace('Api\V1')
    ->prefix('v1')
    ->name('api.v1.')
    ->middleware(['cors'])
    ->group(function () {
        Route::get('/user/list', 'UserController@list')->name('user.list');
        Route::get('/user/show', 'UserController@show')->name('user.show');
        Route::post('/user/login', 'UserController@login')->name('user.login');
        Route::post('/user/logout', 'UserController@logout')->name('user.logout');
        Route::post('/user/register', 'UserController@register')->name('user.register');

        Route::middleware(['refresh.token'])->group(function () {
            Route::get('/user/me', 'UserController@me')->name('user.me');
        });
    });
