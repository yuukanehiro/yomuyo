<?php

 namespace App\Models;

 use Illuminate\Database\Eloquent\Model;
 use Illuminate\Support\Facades\DB;
 use App\Models\Review;
 use Illuminate\Support\Facades\Cache;

class Ranking extends Model
{

    public function rank(string $key=null, int $limit=null, int $number)
    {
        // キーからキャッシュを取得
        //$cache = Cache::get($key);

        // キャッシュがあればキャッシュを返す
        if( isset($cache) ){
            return $json_decode = (int) $cache;
        }else{
            // キャッシュがなければ取得して、キャッシュに保存する
            //$result = DB::table('reviews')
            //                ->select(
            //                            'reviews.book_id',
            //                            //'books.name as book_title',
            //                            DB::raw('count(*) as total'),
            //                            'reviews.id'
            //                        )
            //                ->join('books', 'reviews.book_id', '=', 'books.id')
            //                ->join('users', 'reviews.user_id', '=', 'users.id')
            //                ->groupBy('reviews.book_id')
            //                ->orderBy('total', 'desc')
            //                ->paginate($number);
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



            //Cache::add($key, json_encode($result), $limit); // キャッシュがなければキャッシュする
            return $result;
        }
    }
}
