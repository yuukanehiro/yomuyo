<?php

 namespace App\Http\Controllers;

 use Illuminate\Http\Request;
 use App\Models\Book;           // ←追加 ●Bookモデルを呼び出すよ
 use App\Http\Requests\BookRequest;
 use Illuminate\Pagination\LengthAwarePaginator;
 use Illuminate\Pagination\Paginator;
 use Illuminate\Support\Facades\Log;
 use App\Models\Review;
 use App\Models\Ranking;
 use Illuminate\Support\Facades\Cache;   // キャッシュファサード

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
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
        $ranks  =  $ranking->rankCountReview($key_ranking, $limit_ranking, 6);

        // レビュー総数を取得
        $review = new Review;
        $count =  $review->sum($key_count, $limit_count);

        // 6件ずつレビューを取得
        $reviews = $review->getList($key_reviews, $limit_reviews, 6);
        return view('book.index', ['ranks' => $ranks, 'count' => $count, 'reviews' => $reviews] );
    }


    /** ==================================
     *   Google Books APIから取得
     *  ==================================
     *  @param  BookRequest $request
     *  @return array
     */
    public function search(BookRequest $request)
    {
        $form = $request->all();
        unset($form['_token']); // トークンは削除しておく

        $code = md5($form['name']); // キャッシュキーで日本語を避けたいので変換
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;  // 現在のページ
        $key_data    = "BookController_search_{$code}_{$currentPage}"; // キャッシュキー
        $limit_data  = 604800;                                         // キャッシュ保持期間(604800 = 一週間)


        try{
               if(isset($form['name'])){
                   $post_data  = trim( preg_replace("/( |　)/", "", $form['name']) ); // 著者名 or タイトルを取得(空白を削除)
                   $totalItems = 40;             // APIで取得するデータ最大数
                   $perPage    = 16;              // Paginationでの1ページ当たりの表示数
               }else{
                   $books_flag = 0; // データなし
                   return view('book.result', compact("books_flag") );
               }

               // キーからキャッシュを取得
               if(Cache::has($key_data)){
                   $cache = (array) Cache::get($key_data);
               }

               // キャッシュがあればキャッシュを取得
               if( isset($cache) ){
                   $json_decode = (array) $cache; // 変数名をリネームして合わせる
               }else{ 
                   // Google BooksAPIからデータをJSONで取得して配列化
                   $data = "https://www.googleapis.com/books/v1/volumes?q={$post_data}&country=JP&maxResults={$totalItems}&orderBy=newest&langRestrict=ja";
                   $json = @file_get_contents($data);
                   $json_decode = json_decode($json, true);
                   Cache::add($key_data, $json_decode, $limit_data);
               }


               $books_flag = 1;

               // 本の検索データがあるかを判定
               if($json_decode['totalItems'] == 0)
               {

                   $books_flag = 0; // データなし
                  return view('book.result', compact("post_data", "books_flag") );
               }


               // ページャ用データ作成
               $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;  // 現在のページ
               $itemCollection = collect($json_decode['items']);              // collectヘルパの利用
               $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all(); // $this->slice(配列の切り分け開始位置, 終了位置)
               $paginatedItems = new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
               $paginatedItems->setPath("/book/search/?name={$post_data}");

               return view('book.result', compact("paginatedItems", "post_data", "books_flag") );
        }
        catch(\Exception $e){
            echo "<a href=\"/\">トップページへ戻る</a>:<br/>";
            echo "データ取得エラー。ご迷惑をおかけしております。:" . $e->getMessage();
            Log::error($e->getMessage());
            exit();
        }

    }



    public function detail(Request $request)
    {
            $item  = $request->all();
            unset($item['_token']);

            $review = new Review();
            $reviews = $review->getList(null, null, 2, null, $item['id']);
            return view('book.detail', ["item" => $item, "reviews" => $reviews] );
    }




    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
            //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
            //
    }
}
