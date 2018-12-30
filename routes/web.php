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
Route::get('/', 'UserController@continue');

Route::get('/welcome', function () {
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
Route::get('/logout', 'UserController@logout');
Route::get('/addaction', 'UserController@addaction');
Route::get('/editaction', 'UserController@editaction');


Route::get('/Main', function () {
    return view('pages.Main');
});
Route::get('/index.php', function () {
    return view('pages.Main');
});
Route::get('/Day', function () {
    return view('pages.Day');
});

Route::get('/Today', function () {
    return view('pages.Today');
});

Route::get('/Editpost', function () {
    return view('pages.Editpost');
});