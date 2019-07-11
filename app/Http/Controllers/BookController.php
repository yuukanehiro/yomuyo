<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;           // ←追加 ●Bookモデルを呼び出すよ

use AmazonProduct;

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


    public function search(Request $request)
    {
            $post_data = $request->all();
            $data = "https://www.googleapis.com/books/v1/volumes?q=intitle:{$post_data["name"]}&q=inauthor:{$post_data["name"]}&country=JP";
            $json = file_get_contents($data);
            $json_decode = json_decode($json, true);
            return view('book.result', compact("json_decode", "post_data") );

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
