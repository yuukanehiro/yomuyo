<?php

 namespace App\Http\Controllers;

 use Illuminate\Http\Request;
 use App\Http\Requests\CommentRequest;
 use App\Models\Review;
 use App\Models\Comment;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $item = $request->all();
        unset($item['_token']);

        // レビュー取得
        $review = new Review();
        $review = $review->get($item['id']); // reviews.review_idからレビューを取得

        // サムネイルURL
        $img_url = config('app.img_url');
        $thumanil_url = "https://{$img_url}/books/{$review->thumbnail}";

        // コメントを取得
        $comment = new Comment();
        $per_count = 3;
        $comments = $comment->getList($per_count, $item['id']); // $per_count件ずつコメントを取得
    
        return view('comment.index', ["thumanil_url" => $thumanil_url, "item" => $item, "review" => $review, "comments" => $comments] );
    }

    /** =========================================
     *   コメントを投稿
     *  =========================================
     * 
     */
    public function create(CommentRequest $request)
    {
        $this->middleware('auth'); // コメントを投稿するにはログインしている必要がある。

 
        $item = $request->all();
        unset($item['_token']);

        //var_dump($item);
        //exit();

        // レビュー取得 
        $review = new Review();
        $review = $review->get($item['id']); // reviews.review_idからレビューを取得

        // サムネイルURL
        $img_url = config('app.img_url');
        $thumanil_url = "https://{$img_url}/books/{$review->thumbnail}";

        // コメントを投稿
        $comment = new Comment();
        $comment->regist($item['id'], $item['res']);

        // コメントを取得
        $per_count = 3;
        $comments = $comment->getList($per_count, $item['id']); // $per_count件ずつコメントを取得
        
        return view('comment.index', ["thumanil_url" => $thumanil_url, "item" => $item, "review" => $review, "comments" => $comments] );
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
