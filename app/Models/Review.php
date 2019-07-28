<?php

 namespace App\Models;

 use Illuminate\Database\Eloquent\Model;
 use Illuminate\Support\Facades\DB;      // ←追加 ●DBを操作するのにこれは必須
 use Illuminate\Http\Request;            // ←追加 ●きっと後で使うよ
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
            return $json_decode = (int) $cache;
        }else{
            // キャッシュがなければ取得して、キャッシュに保存する
            $count = DB::table($this->table)->count();
            Cache::add($key, json_encode($count), $limit); // キャッシュがなければキャッシュする
            return $count;
        }
    }

   /** ==========================================================
    *    $number 件 読まれている本を一覧取得
    *   =========================================================
    *   @param string   nullable $key      : キャッシュキー
    *   @param integeer nullable $limit    : キャッシュ保持期間
    *   @param integer           $number   : 取得件数
    *   @param integer  nullable $id       : ユーザID
    *   @return array                      : レビューデータ
    */
    public function getList(string $key = null, int $limit = null, int $number, int $id = null)
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
                                                      'users.name as user_name'
                                                     )
                                             ->join('books',  'reviews.book_id', '=', 'books.id')
                                             ->join('users',  'reviews.user_id', '=', 'users.id')
                                             ->where('users.id', '=', $id)
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
                                                      'users.name as user_name'
                                                     )
                                             ->join('books', 'reviews.book_id', '=', 'books.id')
                                             ->join('users', 'reviews.user_id', '=', 'users.id')
                                             ->orderBy('reviews.updated_at', 'desc')
                                             ->paginate($number);
                return $items;
            }
        }
    }


   /**  ============================
    *    レビューを投稿
    *   ============================
    *   @param Request $request
    *   @return boolean
    */
    public function create(Request $request)
    {
        $request = $request->all();
        unset($request['_token']); //トークン削除

        $user = \Auth::user(); // ログインユーザID取得
        $user_id = $user->id;

        if( isset($request['netabare_flag']) ){
            $request['netabare_flag'] = 1;
        }else{
            $request['netabare_flag'] = 0;
        }


        $jpg = $request['google_book_id'] . '.jpg';


        $notdone = (bool) true; // 初期値
        $retry   = 0;           // リトライ初期値
        $limit   = 3;           // リトライ最大回数閾値
        while( $notdone && $retry < $limit)
        {
            try{
                    // トランザクションスタート!
                    DB::beginTransaction();

                    // books テーブにデータを保存
                    $books_param = [
                        "google_book_id" => $request['google_book_id'], // Googl Books ID
                        "name"           => $request['title'],          // 本のタイトル
                        "thumbnail"      => $jpg,                       // 本のサムネイル
                        'created_at'     => now(),
                        'updated_at'     => now(),
                    ];

                    // 本のレコードがなければ挿入
                    $result = (bool) DB::table('books')->where('google_book_id', $request['google_book_id'])->exists(); //該当本があるか問い合わせ
                    if($result == false)
                    {
                        DB::insert('INSERT INTO books (google_book_id, name, thumbnail, created_at, updated_at)
                                            VALUES(:google_book_id, :name, :thumbnail, :created_at, :updated_at)', $books_param);
                        // booksテーブルに挿入したレコードのid(主キー)を取得
                        $id = DB::getPdo()->lastInsertId();
 
                    // 本のレコードが既にある場合は該当の本のidを取得
                    }else{
                        $rec = DB::table('books')->where('google_book_id', $request['google_book_id'])->get();
                        foreach($rec as $key){
                            $id  = (int) $key->id;
                        }
                    }


                    // reviewsテーブルに保存
                    $reviews_param = [
                        "book_id"        => $id,                         // booksテーブルid
                        "user_id"        => $user_id,                    // ユーザID
                        "netabare_flag"  => $request['netabare_flag'],   // ネタばれフラグ
                        "user_ip"        => \Request::ip(),              // アクセスIP
                        "comment"        => $request['comment'],         // 感想
                        'created_at'     => now(),
                        'updated_at'     => now(),
                    ];

                    DB::insert('INSERT INTO reviews (book_id, user_id, netabare_flag, user_ip, comment, created_at, updated_at)
                                        VALUES(:book_id, :user_id, :netabare_flag, :user_ip, :comment, :created_at, :updated_at)', $reviews_param);


                    // 本のサムネイルをAWS S3 バケット(s3.yomuyo.net/books/)に保存
                    $thumbnail_url = $request['thumbnail'] . '&printsec=frontcover&img=1&zoom=1&edge=curl&source=gbs_api';
                    $img = file_get_contents($thumbnail_url);
                    $id  = $request['google_book_id'];
                    $disk = Storage::disk('s3')->put("books/{$id}.jpg", $img, 'public');

                    // 成功処理
                    DB::commit();
                    return true;
            }catch(\PDOException $e){
                // 失敗処理 : ロールバック。$limit回数まで試行できる
                DB::rollBack();
                $retry++;
            }

        }//while

        // トランザクション処理がリトライ回数の閾値を超えたらエラーを通知して処理を止める
        if($retry == $limit)
        {
            echo get_class() . ':register() PDOException Error. Rollback was executed.' . $e;
            Log::error(get_class() . ':register() PDOException Error. Rollback was executed.' . $e);
            return false; 
        }

    }// create()

}
