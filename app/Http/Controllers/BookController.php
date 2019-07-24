<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;           // ←追加 ●Bookモデルを呼び出すよ
use App\Http\Requests\BookRequest;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Log;
use App\Models\Review;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
            // レビュー総数を取得
            $review = new Review;
            $count = $review->sum();

            // 4件ずつ一覧取得
            $items   = $review->getList(4);
            // 6件ずつレビューを取得
            $reviews = $review->getList(6);
            return view('book.index', compact("count", "items", "reviews"));
    }


    public function search(BookRequest $request)
    {

        try{

            if(isset($request)){
                $post_data  = (string) trim( preg_replace("/( |　)/", "", $request->name) ); // 著者名 or タイトルを取得(空白を削除)
                $totalItems = (int) 40;             // APIで取得するデータ最大数
                $perPage    = (int) 8;              // Paginationでの1ページ当たりの表示数
            }else{
                $books_flag = (int) 0; // データなし
                echo "1";
                exit();
            }
   

            // Google BooksAPIからデータをJSONで取得して配列化
            $data = "https://www.googleapis.com/books/v1/volumes?q={$post_data}&country=JP&maxResults={$totalItems}&orderBy=newest&langRestrict=ja";
            $json = @file_get_contents($data);
            $json_decode = json_decode($json, true);

            $books_flag = (int) 1;
            // 本の検索データがあるかを判定
            if($json_decode['totalItems'] == 0)
            {
                $books_flag = (int) 0; // データなし
                return view('book.result', compact("post_data", "books_flag") );
            }


            // ページャ用データ作成
            $currentPage = LengthAwarePaginator::resolveCurrentPage();  // 現在のページ数を$request['page']の値をLengthAwarePaginator::resolveCurrentPage()で取得
            $itemCollection = collect($json_decode['items']);           // collectヘルパの利用
            $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all(); // $this->slice(配列の切り分け開始位置, 終了位置)
            $paginatedItems = new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
            $paginatedItems->setPath("/book/search/?name={$post_data}");


            return view('book.result', compact("paginatedItems", "post_data", "books_flag") );
        }
        catch(\Exception $e){
            echo "データ取得エラー。ご迷惑をおかけしております。<a href="/">トップページへ戻る</a>";
            Log::error($e->getMessage());
            exit;
        }

    }



    public function detail(Request $request)
    {
            $item  = $request->all();
            return view('book.detail', compact("item") );
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
