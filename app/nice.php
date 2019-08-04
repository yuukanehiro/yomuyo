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
    *   @param  integer  $review_id     : reviews.id レビューID
    *   @param  integer  $login_user_id : users.id   いいねボタンを押したユーザID
    *   @return array    $response['result'] boolean true:処理成功 false:処理失敗
    *                    $response['error']  string  :エラーメッセージ
    */
    public function insert($review_id, $login_user_id)
    {
        $nices_param = [
            "review_id"      => $review_id, 
            "user_id"        => $login_user_id,
            'created_at'     => now(),
            'updated_at'     => now(),
        ];

        try{
        // 本のレコードがなければ挿入
        //$result = (bool) DB::table($this->table)->where('nices.id', $form['google_book_id'])->exists(); //該当本があるか問い合わせ
        //if($result == false)
        //{
            DB::insert('INSERT INTO nices (review_id, user_id, created_at, updated_at)
                                VALUES(:review_id, :user_id, :created_at, :updated_at)', $nices_param);
            
            //Log::info('ほにゃ0');
            $nice_cnt = DB::table($this->table)->select(DB::raw('COUNT(*) AS nice_cnt, review_id'))
                                                  ->where('review_id', '=', $review_id)
                                                  ->group_By('review_id')
                                                  ->get();
            //Log::info($nices_param);
            return $nice_cnt;
        //}
        }catch(PDOException $e){
            Log::error(get_class() . ':register() PDOException Error. ' . $e->getMessage());
        }
    }


}
