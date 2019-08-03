<?php

 namespace App\Models;
 use Illuminate\Support\Facades\DB;
 use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $table = 'comments';

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
}
