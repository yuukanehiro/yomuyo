<?php

 namespace App\Models;

 use Illuminate\Database\Eloquent\Model;
 use Illuminate\Support\Facades\DB;
 use App\Models\Review;
 use Illuminate\Support\Facades\Cache;

class Ranking extends Model
{

    /** ===========================================================
     *   ランキングを取得
     *  ===========================================================
     *  @param  string nullable $key    キャッシュキー
     *  @param  int    nullable $limit  キャッシュ保存期間(秒)
     *  @param  int    nullable $number 取得するレコード数
     *  @return array
     */ 
    public function rank(string $key=null, int $limit=null, int $number)
    {
        // キーからキャッシュを取得
        $cache = Cache::get($key);

        // キャッシュがあればキャッシュを返す
        //if( isset($cache) ){
            //return $json_decode = json_decode($cache, true);
            //return $json_decode = (array) json_decode($cache, true);
            //var_dump($json_decode);
            //exit();
        //}else{
            // キャッシュがなければ取得して、キャッシュに保存する
            $result = DB::select("
                                  SELECT reviews.book_id,
                                         books.name AS book_title,
                                         COUNT(*) AS total,
                                         books.thumbnail,
                                         books.google_book_id
                                  FROM reviews LEFT JOIN books
                                               ON reviews.book_id = books.id
                                  GROUP BY reviews.book_id
                                  ORDER BY total DESC
                                  LIMIT {$number};
                                ");
            $json = json_encode($result);
            Cache::add($key, $json, $limit); // キャッシュする
           return $json_decode = (array) json_decode($json, true);
        //}
    }
}
