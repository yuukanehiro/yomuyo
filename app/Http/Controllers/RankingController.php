<?php

  namespace App\Http\Controllers;
  use Illuminate\Http\Request;
  use App\Models\Review;
  use App\Models\Ranking;
  use Illuminate\Support\Facades\Cache;


class RankingController extends Controller
{

    public function index()
    {
        // キャッシュ設定
        $key_ranking       = (string) "BookController_index_ranking"; // キャッシュキー
        $limit_ranking     = 86400;                                   // キャッシュ保持期間(1日=86400秒)        
        $key_count         = (string) "BookController_index_count";   // キャッシュキー
        $limit_count       = 20;                                      // キャッシュ保持期間
        $key_reviews       = (string) "BookController_index_reviews"; // キャッシュキー
        $limit_reviews     = 30;                                      // キャッシュ保持期間

        // ランキングデータを取得
        $ranking = new Ranking();
        $ranks  =  $ranking->rank($key_ranking, $limit_ranking, 6);

        // レビュー総数を取得
        $review = new Review;
        $count =  $review->sum($key_count, $limit_count);

        // 6件ずつレビューを取得
        $reviews = $review->getList($key_reviews, $limit_reviews, 6);
        return view('ranking.index', ['ranks' => $ranks, 'count' => $count, 'reviews' => $reviews] );
    }

}
