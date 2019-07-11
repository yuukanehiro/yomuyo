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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', 'BookController@index');
Route::post('book/search', 'BookController@search');

Route::get('contact', 'EmailController@contact');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// ログインボタンからのリンク
Route::get('/login/{social}', 'Auth\LoginController@socialLogin')->where('social', 'facebook|twitter');
// ログインボタンからのコールバック
Route::get('/login/{social}/callback', 'Auth\LoginController@handleProviderCallback')->where('social', 'facebook|twitter');
