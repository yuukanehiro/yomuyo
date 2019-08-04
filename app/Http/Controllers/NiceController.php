<?php

  namespace App\Http\Controllers;

  use Illuminate\Http\Request;
  use Response;
  use Log;
  use App\Models\Nice;

class NiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request = $request->all();
        unset($request['_token']);
        $review_id     = $request['review_id'];     // いいねを押したレビューID
        $login_user_id = $request['login_user_id']; // いいねを押したユーザID

        Log::info($review_id);
        exit();

        // いいねのデータ挿入
        $nice = new Nice();
        $nice_cnt = $nice->insert($review_id, $login_user_id);

        session(['nice_cnt' => 'nice_cnt' ]);
        echo $nice_cnt;

        //Log::info($review_id);
        //return Response::json($response);
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
