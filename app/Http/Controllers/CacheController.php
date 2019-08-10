<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cache;
use PHPUnit\Runner\Exception;

class CacheController extends Controller
{

    
    /* ====================
     *   全キャッシュ削除
     * ====================
     */    
    public function flush()
    {
        try{
            Cache::flush();
            echo "すべてのキャッシュを削除しました。";
        } catch (Exception $e){
            echo "エラー： {$e->getMessage()}";
        }
    }


    /* ==============================
     *   トップページキャッシュ削除
     * ==============================
     */    
    public function purgeBook()
    {
        $key_ranking       = Config('cache.cache_key.book_index_ranking'); 
        $key_count         = Config('cache.cache_key.book_index_count');
        $key_review        = Config('cache.cache_key.book_index_review');

        try{
            Cache::forget($key_ranking);
            Cache::forget($key_count);
            Cache::forget($key_review);
            echo "/book/ キャッシュを削除しました。";
        } catch (Exception $e){
            echo "エラー： {$e->getMessage()}";
        }
    }


    /* ==============================
     *   /ranking キャッシュ削除
     * ==============================
     */   
    public function purgeRanking()
    {
        $key_ranking_review    = Config('cache.cache_key.ranking_review');   // キャッシュキー
        $key_ranking_nice      = Config('cache.cache_key.ranking_nice');     // キャッシュキー
        
        try{
            Cache::forget($key_ranking_review);
            Cache::forget($key_ranking_nice);
            echo "/ranking/ キャッシュを削除しました。";
        } catch (Exception $e){
            echo "エラー： {$e->getMessage()}";
        }
    }
}
