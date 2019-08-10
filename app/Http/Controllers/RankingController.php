<?php

  namespace App\Http\Controllers;
  use Illuminate\Http\Request;
  use App\Models\Review;
  use App\Models\Ranking;
  use Illuminate\Support\Facades\Cache;
  use Illuminate\Support\Facades\Config;


class RankingController extends Controller
{

    public function index()
    {
        // キャッシュ設定
        $key_ranking_review    = Config('cache.cache_key.ranking_review');   // キャッシュキー
        $expire_ranking_review = Config('cache.cache_expire.1d');            // キャッシュ保持期間
        $key_ranking_nice      = Config('cache.cache_key.ranking_nice');     // キャッシュキー
        $expire_ranking_nice   = Config('cache.cache_expire.1d');            // キャッシュ保持期間

        $per_page = (int) 12;                                                // 1ページ当たりの表示数


        $ranking = new Ranking();
        // レビュー数の多い本のランキングデータ取得
        $ranks  =  $ranking->rankCountReview((string) $key_ranking_review, (int) $expire_ranking_review, $per_page);
        // いいねが多い本のランキングデータ取得
        $ranks_nice = $ranking->rankCountNice((string) $key_ranking_nice, (int) $expire_ranking_nice, $per_page);

        return view('ranking.index', ['ranks' => $ranks, 'ranks_nice' => $ranks_nice] );
    }

}
