<?php

  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;
  use Illuminate\Support\Facades\DB;
  use Log;


class Nice extends Model
{
    protected $table      = 'nices';      // テーブル名
    protected $primaryKey = 'id';           // PK
    protected $guarded    = array('id');    // PK

   /** ==========================
    *   リレーション
    *  ==========================
    */
    public function review()
    {
        return $this->belogsTo(Review::class);
    }

    public function user()
    {
        return $this->belogsTo(User::class);
    }

   /**  =============================================================================
    *    いいねを追加
    *   =============================================================================
    *   @param  integer  $review_id                           : reviews.id レビューID
    *   @param  integer  $login_user_id                       : users.id   いいねボタンを押したユーザID
    *   @return array    $response['result']    boolean true  : 処理成功 false:処理失敗
    *                    $response['error']     string        : エラーメッセージ
    *                    $response['cnt_nices'] integer       : いいね総数/レビューID毎
    */
    public function insert($review_id, $login_user_id)
    {
        $nices_param = [
            "review_id"      => $review_id, 
            "user_id"        => $login_user_id,
            'created_at'     => now(),
            'updated_at'     => now(),
        ];

        $notdone = (bool) true; // 初期値
        $retry   = 0;           // リトライ初期値
        $limit   = 10;           // リトライ最大回数閾値
        while( $notdone && $retry < $limit)
        {
            try{
        
                    // トランザクションスタート!
                    DB::beginTransaction();
                    
                    // いいねを過去にしているかどうかを判定
                    $result = (bool) DB::table($this->table)->where('nices.review_id', '=', $review_id)
                                                            ->where('user_id', '=', $login_user_id)
                                                            ->exists();
        
                    // いいねがある場合は削除
                    if($result == true)
                    {
                        // いいね削除
                        Nice::where('nices.review_id', '=', $review_id)->where('user_id', '=', $login_user_id)->delete();
        
                        // いいねした記事のいいね総数を取得
                        $cnt = (int) Nice::where('nices.review_id', '=', $review_id)->count();
                        $response = array();
                        $response['cnt_nices'] = $cnt;
        
                    
                    }else{ // 記事がない場合はいいねを挿入
        
                        // いいね！レコード挿入
                        DB::insert('INSERT INTO nices (review_id, user_id, created_at, updated_at)
                                            VALUES(:review_id, :user_id, :created_at, :updated_at)', $nices_param);
        
                        // いいねした記事のいいね総数を取得
                        $cnt = (int) Nice::where('nices.review_id', '=', $review_id)->count();
                        $response = array();
                        $response['cnt_nices'] = $cnt;
                    }
        
                    // 成功処理
                    DB::commit();
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
    }





}
