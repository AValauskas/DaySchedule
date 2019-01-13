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
Route::get('/forgotpass', function () {
    return view('pages.forgotpass');
});


Route::post('/store', 'UserController@store');
Route::post('/log', 'UserController@log');
Route::get('/logout', 'UserController@logout');
Route::get('/sendmail', 'UserController@sendmail');
Route::get('/changepass', 'UserController@changepass');
Route::get('/addaction', 'PostsController@addaction');
Route::get('/editaction', 'PostsController@editaction');
Route::get('/deletepost', 'PostsController@deletepost');
Route::get('/poststatus', 'PostsController@poststatus');
Route::get('/adddiary', 'DiaryController@adddiary');
Route::get('/editdiary', 'DiaryController@editdiary');
Route::get('/deletediaryDay', 'DiaryController@deletediaryDay');
Route::get('/deletediaryJournal', 'DiaryController@deletediaryJournal');
Route::get('/editinfo', 'UserController@editinfo');
Route::get('/evaluate', 'EvaluateController@evaluate');






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

Route::get('/Diary', function () {
    return view('pages.Diary');
});

Route::get('/editcustomerinfo', function () {
    return view('pages.editcustomerinfo');
});
Route::get('/Todaydisplay', function () {
    return view('pages.Todaydisplay');
});
Route::get('/DiaryDisplay', function () {
    return view('pages.DiaryDisplay');
});
Route::get('/DisplayValues', function () {
    return view('pages.DisplayValues');
});