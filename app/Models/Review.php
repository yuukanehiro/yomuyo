<?php

 namespace App\Models;

 use Illuminate\Database\Eloquent\Model;
 use Illuminate\Support\Facades\DB;      
 use Illuminate\Http\Request;            
 use Storage;                            // AWS S3アクセス league/flysystem-aws-s3-v3
 use Illuminate\Support\Facades\Log;     // ログ
 use Illuminate\Support\Facades\Cache;   // キャッシュファサード


class Review extends Model
{
    protected $table      = 'reviews';      // テーブル名
    protected $primaryKey = 'id';           // PK
    protected $guarded    = array('id');    // PK


   /** ==========================
    *   リレーション
    *  ==========================
    */
    public function book()
    {
        return $this->belogsTo(Book::class);
    }

    public function user()
    {
        return $this->belogsTo(User::class);
    }

    public function comment()
    {
        return $this->hasMany(Comment::class);
    }

    public function nice()
    {
        return $this->hasMany(Nice::class);
    }

   /** =======================================================
    *   レビュー総件数を取得
    *  ========================================================
    *   @param  string  $key     : キャッシュのキー
    *   @param  integer $limit   : 保持期間(秒)
    *   @return integer $cache   : キャッシュ(レビュー総件数)
    *   @return integer $count   : レビュー総件数
    */
    public function sum(string $key, int $limit)
    {  
        // キーからキャッシュを取得 
        $cache = Cache::get($key);
      
        // キャッシュがあればキャッシュを返す
        if( isset($cache) ){
            return (int) json_decode($cache, true);
        }else{
            // キャッシュがなければ取得して、キャッシュに保存する
            $count = DB::table($this->table)->count();
            $json  = json_encode($count);
            Cache::add($key, json_encode($json), $limit); // キャッシュがなければキャッシュする

            return (int) $count;
        }
    }

   /** ==========================================================
    *    $number 件 読まれている本を一覧取得
    *   =========================================================
    *   @param string   nullable $key             : キャッシュキー
    *   @param integeer nullable $limit           : キャッシュ保持期間
    *   @param integer           $number          : 取得件数
    *   @param integer  nullable $id              : ユーザID
    *   @param string   nullable $google_book_id  : Google Books ID
    *   @return array                             : レビューデータ
    */
    public function getList(
                              string $key=null, 
                              int $limit=null,
                              int $number,
                              int $id=null,
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
                                                            DB::RAW("COUNT(DISTINCT comments.id) AS cnt_comments"),
                                                            DB::RAW("COUNT(DISTINCT nices.user_id)    AS cnt_nices")
                                                     )
                                             ->leftjoin('comments',  'comments.review_id', '=', 'reviews.id')
                                             ->leftjoin('nices',     'nices.review_id',        '=', 'reviews.id')
                                             ->join('books',     'reviews.book_id',    '=', 'books.id')
                                             ->join('users',     'reviews.user_id',    '=', 'users.id')
                                             ->where('users.id', '=', $id)
                                             ->groupBy(DB::raw('reviews.id'))
                                             ->orderBy('reviews.created_at', 'desc')
                                             ->paginate($number);

                return $items;

             // Google Books IDがある場合
            }elseif( isset($google_book_id)){
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
                                                      DB::RAW("COUNT(DISTINCT nices.user_id)    AS cnt_nices")
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
                                                      DB::RAW("COUNT(DISTINCT nices.user_id)    AS cnt_nices")
                                                     )
                                             ->leftjoin('comments',  'comments.review_id', '=', 'reviews.id')
                                             ->leftjoin('nices',     'nices.review_id',        '=', 'reviews.id')
                                             ->join('books', 'reviews.book_id',            '=', 'books.id')
                                             ->join('users', 'reviews.user_id',            '=', 'users.id')
                                             ->groupBy(DB::raw('reviews.id'))
                                             ->orderBy('reviews.updated_at', 'desc')
                                             ->paginate($number);
                //echo "<pre>";                              
                //var_dump($items);
                //echo "</pre>"; 
                //exit();
                return $items;
            }
        }
    }



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
                                                      'users.name as user_name'
                                                     )
                                             ->join('books',  'reviews.book_id', '=', 'books.id')
                                             ->join('users',  'reviews.user_id', '=', 'users.id')
                                             ->where('reviews.id', '=', $id)
                                             ->first();
            return $items;
    }



   /**  =============================================================================
    *    レビューを投稿
    *    (画像はS3へアップロード)
    *   =============================================================================
    *   @param  array    $form
    *   @return array    $response['result'] boolean true:処理成功 false:処理失敗
    *                    $response['error']  string  :エラーメッセージ
    */
    public function create($form)
    {
        $user = \Auth::user(); // ログインユーザID取得
        $user_id = $user->id;


        if( isset($form['netabare_flag']) ){
            $form['netabare_flag'] = 1;
        }else{
            $form['netabare_flag'] = 0;
        }


        $jpg = $form['google_book_id'] . '.jpg';


        $notdone = (bool) true; // 初期値
        $retry   = 0;           // リトライ初期値
        $limit   = 10;           // リトライ最大回数閾値
        while( $notdone && $retry < $limit)
        {
            try{
                    // トランザクションスタート!
                    DB::beginTransaction();

                    // books テーブにデータを保存
                    $books_param = [
                        "google_book_id" => $form['google_book_id'], // Googl Books ID
                        "name"           => $form['title'],          // 本のタイトル
                        "thumbnail"      => $jpg,                       // 本のサムネイル
                        'created_at'     => now(),
                        'updated_at'     => now(),
                    ];

                    // 本のレコードがなければ挿入
                    $result = (bool) DB::table('books')->where('google_book_id', $form['google_book_id'])->exists(); //該当本があるか問い合わせ
                    if($result == false)
                    {
                        DB::insert('INSERT INTO books (google_book_id, name, thumbnail, created_at, updated_at)
                                            VALUES(:google_book_id, :name, :thumbnail, :created_at, :updated_at)', $books_param);
                        // booksテーブルに挿入したレコードのid(主キー)を取得
                        $id = DB::getPdo()->lastInsertId();
 
                    // 本のレコードが既にある場合は該当の本のidを取得
                    }else{
                        $rec = DB::table('books')->where('google_book_id', $form['google_book_id'])->get();
                        foreach($rec as $key){
                            $id  = (int) $key->id;
                        }
                    }


                    // reviewsテーブルに保存
                    $reviews_param = [
                        "book_id"        => $id,                         // booksテーブルid
                        "user_id"        => $user_id,                    // ユーザID
                        "netabare_flag"  => $form['netabare_flag'],      // ネタばれフラグ
                        "user_ip"        => \Request::ip(),              // アクセスIP
                        "comment"        => $form['comment'],            // 感想
                        'created_at'     => now(),
                        'updated_at'     => now(),
                    ];

                    DB::insert('INSERT INTO reviews (book_id, user_id, netabare_flag, user_ip, comment, created_at, updated_at)
                                       VALUES(:book_id, :user_id, :netabare_flag, :user_ip, :comment, :created_at, :updated_at)', $reviews_param);


                    // 本のサムネイルをAWS S3 バケット(s3.yomuyo.net/books/)に保存
                    $thumbnail_url = $form['thumbnail'] . '&printsec=frontcover&img=1&zoom=1&edge=curl&source=gbs_api';
                    $img = file_get_contents($thumbnail_url);
                    $id  = $form['google_book_id'];
                    $disk = Storage::disk('s3')->put("books/{$id}.jpg", $img, 'public');

                    // 成功処理
                    DB::commit();
                    $response = array();
                    $response['result'] = true;
                    return $response;
            }catch(\PDOException $e){
                // 失敗処理 : ロールバック。$limit回数まで試行できる
                DB::rollBack();
                $retry++;
            }

        }//while

        // トランザクション処理がリトライ回数の閾値を超えたらエラーを通知して処理を止める
        if($retry == $limit)
        {
            $response = array();
            $response['result'] = false;
            $response['error'] = get_class() . ':register() PDOException Error. Rollback was executed.' . $e->getMessage();
            Log::error(get_class() . ':register() PDOException Error. Rollback was executed.' . $e->getMessage());
            return $response; 
        }

    }// create()

}
