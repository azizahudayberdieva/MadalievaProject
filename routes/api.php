<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth',
    'namespace' => 'Auth'
], function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

Route::resources([
    'posts' => 'PostController',
    'categories' => 'CategoryController',
    'users' => 'UserController'
]);

Route::post('post-search-form', '\App\Forms\PostsSearchForm@get');

Route::get('/roles', 'RoleController@index');
