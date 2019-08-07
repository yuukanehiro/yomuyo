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



// メインページ
Route::get('/',                    'BookController@index');   // トップページ
Route::post('/book/search',        'BookController@search');  // 検索
Route::get('/book/search',         'BookController@search');

Route::post('/book/detail',        'BookController@search');  // 詳細ページ
Route::get('/book/detail',         'BookController@detail');


// お問合せ
Route::get('/contact', 'EmailController@contact');

// 説明ページ Yomuyoとは
Route::get('/describe', function () {
  return view('describe');
});

// ランキングページ
Route::get('/ranking',   'RankingController@index');
Route::post('/ranking',  'RankingController@index');


// 会員ページ
Route::get('/mypage',              'MypageController@index');
Route::post('/mypage',             'MypageController@index');
Route::get('/mypage/post',         'MypageController@index');
Route::post('/mypage/post',        'MypageController@post');
Route::get('/mypage/review/del',   'MypageController@destroy'); // レビュー削除
Route::get('/mypage/review/edit',  'MypageController@show');    // レビュー編集ページ表示
Route::post('/mypage/review/edit', 'MypageController@edit');    // レビュー編集実行

// コメント一覧ページ
Route::get('/comment/',        'CommentController@index');
Route::get('/comment/create',  'CommentController@create');
Route::post('/comment/create', 'CommentController@create')->middleware('auth');

// いいねボタン
Route::post('niceAjax' , 'NiceController@create'); 


// ログイン関連
Auth::routes();
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout'); // ログアウト

// ソーシャルログイン
Route::get('/auth/redirect/{provider}', 'SocialController@redirect');
Route::get('/auth/callback/{provider}', 'SocialController@callback');
