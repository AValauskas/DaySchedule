<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/registration', function () {
    return view('pages.registration');
});
Route::get('/login', function () {
    return view('pages.login');
});
Route::post('/store', 'UserController@store');
Route::post('/log', 'UserController@log');

Route::get('/Main', function () {
    return view('pages.Main');
});


