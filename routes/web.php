<?php

use Illuminate\Support\Facades\Route;
Route::get('/', 'GeneralController@index')->name('mainPage');
Route::get('/home', 'GeneralController@home')->name('home');
Route::post('/store', 'GeneralController@storeFile');
