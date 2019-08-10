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
        $key_ranking_review    = (string) "BookController_index_ranking_review";  // キャッシュキー
        $limit_ranking_review  = 86400;                                           // キャッシュ保持期間(1日=86400秒)
        $key_ranking_nice      = (string) "BookController_index_ranking_nice";    // キャッシュキー
        $limit_ranking_nice    = 86400;                                           // キャッシュ保持期間(1日=86400秒)


        $ranking = new Ranking();
        // レビュー数の多い本のランキングデータ取得
        $ranks  =  $ranking->rankCountReview($key_ranking_review, $limit_ranking_review, 12);
        // いいねが多い本のランキングデータ取得
        $ranks_nice = $ranking->rankCountNice($key_ranking_nice, $limit_ranking_nice, 12);

        
        return view('ranking.index', ['ranks' => $ranks, 'ranks_nice' => $ranks_nice] );
    }

}
