<?php

  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;
  use Illuminate\Support\Facades\DB;
  use Log;

class Following extends Model
{
    protected $table      = 'followings';      // テーブル名
    protected $primaryKey = 'id';              // PK
    protected $guarded    = array('id');       // PK

   /** ==========================
    *   リレーション
    *  ==========================
    */
    public function review()
    {
        return $this->belogsTo(User::class);
    }



   /**  ===================================================================================================
    *    フォローを追加
    *   ===================================================================================================
    *   @param  integer  $follow_user_id                           : followings.following_user_id ユーザID
    *   @param  integer  $login_user_id                            : followings.user_id ユーザID   いいねボタンを押したユーザID
    *   @return array    $response['result']         boolean true  : 処理成功 false:処理失敗
    *                    $response['error']          string        : エラーメッセージ
    *                    $response['cnt_following']  integer       : いいね総数/レビューID毎
    */
    public function insert(int $follow_user_id, int $login_user_id)
    {
        $followings_param = [
            "following_user_id"      => $follow_user_id, 
            "user_id"                => $login_user_id,
            'created_at'             => now(),
            'updated_at'             => now(),
        ];

        $notdone = (bool) true;  // 初期値
        $retry   = 0;            // リトライ初期値
        $limit   = 10;           // リトライ最大回数閾値
        while( $notdone && $retry < $limit)
        {
            try{
                    // トランザクションスタート!
                    DB::beginTransaction();
                    
                    // フォローをしているかどうかを判定                    
                    $result = self::isExist($follow_user_id, $login_user_id);
        
                    // フォローがある場合は削除
                    if($result == true)
                    {
                        // フォローしている場合は削除
                        Following::where('followings.following_user_id', '=', $follow_user_id)
                                   ->where('user_id', '=', $login_user_id)
                                   ->delete();
        
                        // フォロー総数を取得
                        $response = array();
                        $cnt_following = self::getCount($follow_user_id);
                        $response['cnt_following'] = $cnt_following;
                    
                    }else{ // フォロー対象ユーザがない場合はfollowingsテーブルに挿入
        
                        // フォロー追加
                        DB::insert('INSERT INTO followings (user_id, following_user_id, created_at, updated_at)
                                            VALUES(:user_id, :following_user_id, :created_at, :updated_at)', $followings_param);

                        // フォロー総数を取得
                        $response = array();
                        $cnt_following = self::getCount($follow_user_id);
                        $response['cnt_following'] = $cnt_following;
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



   /**  ===================================================================================================
    *    フォローしているかを判定
    *   ===================================================================================================
    *   @param  integer  $follow_user_id  : followings.following_user_id ユーザID
    *   @param  integer  $login_user_id   : followings.user_id ユーザID   いいねボタンを押したユーザID
    *   @return array    $result          : boolean true  : 既にフォローしている false:まだフォローしていない
    */
    public function isExist(int $follow_user_id, int $login_user_id)
    {
        // フォローをしているかどうかを判定
        $result = (bool) DB::table($this->table)->where('followings.following_user_id', '=', $follow_user_id)
                                ->where('followings.user_id', '=', $login_user_id)
                                ->exists();
        return $result;
    }



   /**  ===================================================================================================
    *    フォローしている数を取得
    *   ===================================================================================================
    *   @param  integer  $user_id                                  : ユーザID
    *   @return array    $response['result']         boolean true  : 処理成功 false:処理失敗
    */
    public function getCount(int $user_id)
    {
        try{
                $cnt_following = (int) Following::where('followings.user_id', '=', $user_id)->count();
                return $cnt_following;
            }catch(\PDOException $e){
                $response = array();
                $response['result'] = false;
                $response['error'] = get_class() . ':getCount() PDOException Error. ' . $e->getMessage();
                Log::error(get_class() . ':getCount() PDOException Error.' . $e->getMessage());
                return $response;
            }
    }



   /**  ===================================================================================================
    *    フォロー中のユーザリストを取得
    *   ===================================================================================================
    *   @param  integer  $user_id                                  : ユーザID
    *   @return array    $response['result']         boolean true  : 処理成功 false:処理失敗
    */
    public function getList(int $user_id)
    {
        try{
            $following_recs = DB::table($this->table)->select(
                                                                  'followings.following_user_id AS user_id',
                                                                  'users.name                   AS user_name',
                                                                  'users.comment                AS user_comment'
                                                             )
                                                     ->leftjoin('users',  'users.id', '=', 'followings.following_user_id')
                                                     ->where("followings.user_id",    "=", $user_id)
                                                     ->get();
            return $following_recs;
        }catch(\PDOException $e){
            $response = array();
            $response['result'] = false;
            $response['error'] = get_class() . ':getList() PDOException Error.' . $e->getMessage();
            Log::error(get_class() . ':getList() PDOException Error.' . $e->getMessage());
            return $response;
        }
    }

}
