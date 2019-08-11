<?php

  namespace App\Http\Controllers;

  use Illuminate\Http\Request;
  use App\Models\Review;
  use App\Models\Comment;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // ユーザのレビュー情報取得
        $user_id     = $request->user_id;

        $review = new Review();
        $reviews = $review->getList(null, null, 5, $user_id);

        // echo "<pre>";
        // var_dump($reviews);
        // echo "</pre>";
        // exit();

        return view('user.index', ["reviews" => $reviews]);
    }
}
