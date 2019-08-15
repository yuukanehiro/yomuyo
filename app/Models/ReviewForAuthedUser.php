<?php

  namespace App\Models;

  use Illuminate\Support\Facades\Auth;
  use Illuminate\Database\Eloquent\Model;
  use Illuminate\Support\Facades\DB;
  use Illuminate\Http\Request;
  use Storage;                            // AWS S3アクセス league/flysystem-aws-s3-v3
  use Illuminate\Support\Facades\Log;     // ログ
  use Illuminate\Support\Facades\Cache;   // キャッシュファサード

  error_reporting(E_ALL);

/** ===============================================================================
 *   ログインしているユーザ向けに、
 *   getList()でいいねを押しているかを判定する拡張をReviewモデルクラスに行いたかった
 *  ===============================================================================
 *
*/
class ReviewForAuthedUser extends Review
{

    private $login_user_id;

    public function __construct()
    {
        // ログインしているユーザのIDを取得
        $this->login_user_id = (int) Auth::id();
    }

    /** ==================================================================
      *    $number 件 読まれている本を一覧取得
      *   =================================================================
      *   @param string   nullable $key             : キャッシュキー
      *   @param integeer nullable $limit           : キャッシュ保持期間
      *   @param integer           $number          : 取得件数
      *   @param integer  nullable $id              : ユーザID
      *   @param string   nullable $google_book_id  : Google Books ID
      *   @return array                             : レビューデータ
      */

      public function getList(
                                string $key=null,
                                int    $limit=null,
                                int    $number,
                                int    $id=null,
                                string $google_book_id=null
                              )
      {



          // キーからキャッシュを取得
          $cache = Cache::get($key);
          // キャッシュがあればキャッシュを返す
          if( isset($cache) ){
          $json_decode = (int) $cache;
          }else{

                  if( isset($id) )
                  {
                  // users.idが指定されている場合: 任意のユーザのレビューを作成日時による降順で取得
                  $items = DB::table($this->table)->select(
                                                      'reviews.id',
                                                      'reviews.book_id',
                                                      'reviews.user_id',
                                                      'reviews.netabare_flag',
                                                      'reviews.comment',
                                                      'reviews.updated_at',
                                                      'books.google_book_id',
                                                      'books.name as book_title',
                                                      'books.thumbnail',
                                                      'users.name AS user_name',
                                                      'users.id AS user_id',
                                                      'users.comment AS user_comment',
                                                      'users.website AS user_website',
                                                      DB::RAW("COUNT(DISTINCT comments.id)      AS cnt_comments"),
                                                      DB::RAW("COUNT(DISTINCT nices.user_id)    AS cnt_nices"),
                                                      DB::raw("
                                                                (CASE WHEN nices.user_id = {$this->login_user_id}
                                                                      THEN 1
                                                                      ELSE 0
                                                                END
                                                                ) AS hasNice
                                                              ")
                                              )
                                      ->leftjoin('comments',  'comments.review_id', '=', 'reviews.id')
                                      ->leftjoin('nices',     'nices.review_id',        '=', 'reviews.id')
                                      ->join('books',     'reviews.book_id',    '=', 'books.id')
                                      ->join('users',     'reviews.user_id',    '=', 'users.id')
                                      ->where('users.id', '=', $id)
                                      ->groupBy(DB::raw('reviews.id'))
                                      ->orderBy('reviews.created_at', 'desc')
                                      ->paginate($number);

                  // Google Books IDがある場合
                  }elseif( isset($google_book_id) ){
                      $items = DB::table($this->table)->select(
                                                                  'reviews.id',
                                                                  'reviews.book_id',
                                                                  'reviews.user_id',
                                                                  'reviews.netabare_flag',
                                                                  'reviews.comment',
                                                                  'reviews.updated_at',
                                                                  'books.google_book_id',
                                                                  'books.name as book_title',
                                                                  'books.thumbnail',
                                                                  'users.name as user_name',
                                                                  DB::RAW("COUNT(DISTINCT comments.id) AS cnt_comments"),
                                                                  DB::RAW("COUNT(DISTINCT nices.user_id)    AS cnt_nices"),
                                                                  DB::raw("
                                                                              (CASE WHEN nices.user_id = {$this->login_user_id}
                                                                                    THEN 1
                                                                                    ELSE 0
                                                                              END
                                                                              ) AS hasNice
                                                                          ")
                                                              )
                                                      ->leftjoin('comments',  'comments.review_id', '=', 'reviews.id')
                                                      ->leftjoin('nices',     'nices.review_id',        '=', 'reviews.id')
                                                      ->join('books',  'reviews.book_id', '=', 'books.id')
                                                      ->join('users',  'reviews.user_id', '=', 'users.id')
                                                      ->where('books.google_book_id', '=', $google_book_id)
                                                      ->groupBy(DB::raw('reviews.id'))
                                                      ->orderBy('reviews.created_at', 'desc')
                                                      ->paginate($number);
                      return $items;
                  }else{
                            // users.idが指定されていない場合: 全件からレビューを更新日時による降順で取得
                            $items = DB::table($this->table)->select(
                                                                        'reviews.id',
                                                                        'reviews.book_id',
                                                                        'reviews.user_id',
                                                                        'reviews.netabare_flag',
                                                                        'reviews.comment',
                                                                        'reviews.updated_at',
                                                                        'books.google_book_id',
                                                                        'books.name as book_title',
                                                                        'books.thumbnail',
                                                                        'users.name AS user_name',
                                                                        DB::RAW("COUNT(DISTINCT comments.id) AS cnt_comments"),
                                                                        DB::RAW("COUNT(DISTINCT nices.user_id)    AS cnt_nices"),
                                                                        DB::raw("
                                                                                    (CASE WHEN nices.user_id = {$this->login_user_id}
                                                                                          THEN 1
                                                                                          ELSE 0
                                                                                    END
                                                                                    ) AS hasNice
                                                                               ")
                                                                    )
                                                            ->leftjoin('comments',  'comments.review_id', '=', 'reviews.id')
                                                            ->leftjoin('nices',     'nices.review_id',        '=', 'reviews.id')
                                                            ->join('books', 'reviews.book_id',            '=', 'books.id')
                                                            ->join('users', 'reviews.user_id',            '=', 'users.id')
                                                            ->groupBy(DB::raw('reviews.id'))
                                                            ->orderBy('reviews.updated_at', 'desc')
                                                            ->paginate($number);
                            return $items;
                  }
          }
      }



    /** ====================================================
    *    reviews.idを指定して1件のレビューデータを取得
    *  ====================================================
    */
    public function get($id)
    {
        $items = DB::table($this->table)->select(
                                                    'reviews.id',
                                                    'reviews.book_id',
                                                    'reviews.user_id',
                                                    'reviews.netabare_flag',
                                                    'reviews.comment',
                                                    'reviews.updated_at',
                                                    'books.google_book_id',
                                                    'books.name as book_title',
                                                    'books.thumbnail',
                                                    'users.name as user_name',
                                                    DB::RAW("COUNT(DISTINCT comments.id) AS cnt_comments"),
                                                    DB::RAW("COUNT(DISTINCT nices.user_id)    AS cnt_nices"),
                                                    DB::raw('
                                                                (CASE WHEN nices.user_id = 1
                                                                      THEN 1
                                                                      ELSE 0
                                                                END
                                                                ) AS hasNice
                                                          ')
                                                )
                                        ->leftjoin('comments',  'comments.review_id', '=', 'reviews.id')
                                        ->leftjoin('nices',     'nices.review_id',        '=', 'reviews.id')
                                        ->join('books',  'reviews.book_id', '=', 'books.id')
                                        ->join('users',  'reviews.user_id', '=', 'users.id')
                                        ->where('reviews.id', '=', $id)
                                        ->first();
        return $items;
    }

}
