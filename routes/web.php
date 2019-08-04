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

Route::get('/describe', function () {
    return view('describe');
});


Route::get('/', 'BookController@index');
Route::post('/book/search', 'BookController@search');
Route::get('/book/search', 'BookController@search');
Route::post('/book/search/search', 'BookController@search');

Route::post('/book/detail', 'BookController@search');
Route::get('/book/detail', 'BookController@detail');


Route::get('/contact', 'EmailController@contact');

Auth::routes();



Route::get('/mypage',              'MypageController@index');
Route::post('/mypage',             'MypageController@index');
Route::get('/mypage/post',         'MypageController@index');
Route::post('/mypage/post',        'MypageController@post');
Route::get('/mypage/review/del',   'MypageController@destroy'); // レビュー削除
Route::get('/mypage/review/edit',  'MypageController@show');    // レビュー編集ページ表示
Route::post('/mypage/review/edit', 'MypageController@edit');    // レビュー編集実行

Route::get('/comment/',        'CommentController@index');
Route::post('/comment/create', 'CommentController@create')->middleware('auth');

Route::post('/nice/create/' , 'NiceController@create');
//Route::get('/nice/create/'  , 'NiceController@create');

// ソーシャルログイン
Route::get('/auth/redirect/{provider}', 'SocialController@redirect');
Route::get('/auth/callback/{provider}', 'SocialController@callback');
