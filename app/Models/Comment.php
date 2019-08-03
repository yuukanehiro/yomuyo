<?php

 namespace App\Models;
 use Illuminate\Support\Facades\DB;
 use Illuminate\Database\Eloquent\Model;
 use Illuminate\Support\Facades\Log;     // ログ

class Comment extends Model
{

    protected $table      = 'comments';
    protected $primaryKey = 'id';           // PK
    protected $fillable = [
                               'review_id',
                               'user_id', 
                               'comment',
                               'user_ip',
                               'created_at',
                               'updated_at'
                          ];


   /** ==========================
    *   リレーション
    *  ==========================
    */
    public function review()
    {
        return $this->belogsTo(review::class);
    }


   /** ==========================================================
    *    $number 件 コメントを一覧取得
    *   =========================================================
    *   @param integer           $per_count    : 1ページ表示件数
    *   @param integer           $review_id    : reviews.id
    *   @return array                             
    */
    public function getList(
                              int $per_count,
                              int $review_id
                           )
    {

        // users.idが指定されている場合: 任意のユーザのレビューを作成日時による降順で取得
        $items = DB::table($this->table)->select(
                                                    'comments.id',
                                                    'comments.comment',
                                                    'users.name as user_name'
                                                )
                                        ->join('reviews',  'comments.review_id', '=', 'reviews.id')
                                        ->join('users',    'comments.user_id',   '=', 'users.id')
                                        ->where('review_id', '=', $review_id)
                                        ->orderBy('comments.created_at', 'asc')
                                        ->paginate($per_count);
        
        return $items;
    }


   /** ==========================================================
    *    コメントの投稿
    *   =========================================================
    *   @param  integer           $review_id    : reviews.id
    *   @param  string            $res          : レビューへのコメント本文 comments.comment
    */
    public function regist( int $review_id, string $res)
    {
        $user = \Auth::user(); // ログインユーザID取得
        $user_id = $user->id;

        // reviewsの該当レコードの存在を確認し、存在していればコメントを投稿

            $notdone = (bool) true; // 初期値
            $retry   = 0;           // リトライ初期値
            $limit   = 3;           // リトライ最大回数閾値
            while( $notdone && $retry < $limit)
            {
                try{
                        // トランザクションスタート!
                        DB::beginTransaction();

                        // books テーブにデータを保存
                        $comments_param = [
                            "review_id"      => $review_id,        // reviews.id
                            "user_id"        => $user_id,          // users.id
                            "comment"        => $res,              // レビューへのコメント
                            "user_ip"        => \Request::ip(),    // アクセスIP
                            'created_at'     => now(),
                            'updated_at'     => now(),
                        ];

                        //echo "2";
                        //echo "<pre>";
                        //var_dump($comments_param);
                        //echo "</pre>";
                        //exit();


                        $review_exist = (bool) review::where('reviews.id', '=', $review_id)->exists();
                        if($review_exist)
                        {
                            //echo "SQL実行前";
                            //exit();
                            $result = DB::insert('INSERT INTO comments (review_id, user_id, comment, user_ip, created_at, updated_at)
                                                         VALUES(:review_id, :user_id, :comment, user_ip, :created_at, :updated_at', $comments_param);
                            echo "SQL実行後";
                            exit();                    
                        }else{
                            echo "レビューが削除されているようです。コメントを投稿できません。ごめんなさい。";
                            exit();
                        }

                        var_dump($review_exist);
                        echo "3";
                        exit();


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
                $response['error'] = get_class() . ':register() PDOException Error. Rollback was executed.' . $e;
                Log::error(get_class() . ':regist() PDOException Error. Rollback was executed.' . $e);
                return $response;
            }

    }


}
