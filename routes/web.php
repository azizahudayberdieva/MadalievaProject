<?php

use Illuminate\Support\Facades\Route;
Route::get('/', 'GeneralController@index')->name('mainPage');
Route::get('/home', 'GeneralController@home')->name('home');
Route::post('/store', 'GeneralController@storeFile');

Route::get('/test',function() {
    $user = App\Models\User::find(9);
});
