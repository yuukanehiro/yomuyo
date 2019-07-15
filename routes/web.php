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

// ProductionならHTTPSに変更
if (app()->environment('production')) {
  URL::forceScheme('https');
}



Route::get('/', 'BookController@index');
Route::post('book/search', 'BookController@search');
Route::get('book/search', 'BookController@search');

Route::post('book/detail', 'BookController@search');
Route::get('book/detail', 'BookController@detail');


Route::get('contact', 'EmailController@contact');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// ソーシャルログイン
Route::get('/auth/redirect/{provider}', 'SocialController@redirect');
Route::get('/auth/callback/{provider}', 'SocialController@callback');
