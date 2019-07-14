<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;           // ←追加 ●Bookモデルを呼び出すよ
use App\Http\Requests\BookRequest;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;


class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
            return view('book.index');
    }


    public function search(BookRequest $request)
    {
            $post_data  = (string) trim( preg_replace("/( |　)/", "", $request->name) ); // 著者名 or タイトルを取得(空白を削除)
            $totalItems = (int) 40;             // APIで取得するデータ最大数
            $perPage    = (int) 8;              // Paginationでの1ページ当たりの表示数

            // Google BooksAPIからデータをJSONで取得して配列化
            $data = "https://www.googleapis.com/books/v1/volumes?q={$post_data}&country=JP&maxResults={$totalItems}&orderBy=newest&langRestrict=ja";
            $json = file_get_contents($data);
            $json_decode = json_decode($json, true);

            $books_flag = (int) 1;
            // 本の検索データがあるかを判定
            if($json_decode['totalItems'] == 0)
            {
                $books_flag = (int) 0; // データなし
                return view('book.result', compact("post_data", "books_flag") );
            // PKEYがあるかを判定(ISBNコードがないデータはPKEYが設定されている)
            }


            
            // ISBNレコードのないデータを配列から削除
            $cnt = (int) 0;
            $cnt = count($json_decode["items"]);
            for($i = 0; $i < $cnt; $i++)
            {
                //echo "TEST";
                //echo "<pre>";
                //var_dump($json_decode["items"][$i]["volumeInfo"]["industryIdentifiers"][0]["type"])
                //var_dump($json_decode);
                //echo "</pre>";
                //exit();

                //if(array_key_exists("industryIdentifiers", $json_decode["items"][$i]))
                if( isset($json_decode["items"][$i]["volumeInfo"]["industryIdentifiers"][0]) )
                { 
                    //if($json_decode["items"][$i]["volumeInfo"]["industryIdentifiers"][0]["type"] == "ISBN_10"){
                    if((preg_match('/ISBN_10|ISBN_13/', $json_decode["items"][$i]["volumeInfo"]["industryIdentifiers"][0]["type"]))){
                        continue;
                    }
                }else{
                    //echo "<pre>";
                    //var_dump($json_decode["items"][$i]["volumeInfo"]);
                    //echo "</pre>";
                    unset($json_decode['items'][$i]);
                    //echo "<h1>Flag2 配列：{$i}</h1>";
                }
            }
            array_merge($json_decode); // 配列のインデックスを詰める
            //echo "<pre>";
            //var_dump($json_decode);
            //echo "</pre>";
            //exit();



            $currentPage = LengthAwarePaginator::resolveCurrentPage();  // 現在のページ数を$request['page']の値をLengthAwarePaginator::resolveCurrentPage()で取得
            $itemCollection = collect($json_decode['items']);           // collectヘルパの利用
            $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all(); // $this->slice(配列の切り分け開始位置, 終了位置)
            $paginatedItems = new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
            $paginatedItems->setPath("/book/search/?name={$post_data}");
            return view('book.result', compact("paginatedItems", "post_data", "books_flag") );

    }

    public function detail(BookRequest $request)
    {
            $post_data  = $request->isbn; // ISBN

            // Google BooksAPIからデータをJSONで取得して配列化
            
            $json = file_get_contents($data);
            $json_decode = json_decode($json, true);

            return view('book.detail', compact("$json_decode", "post_data", "books_flag") );

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
