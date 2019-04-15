<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->get('users', 'UsersController@index');
    $router->get('userinfos', 'UserInfoController@index');

    $router->get('userinfos/{id}/edit', 'UserInfoController@edit');
    $router->put('userinfos/{id}', 'UserInfoController@update');
});
