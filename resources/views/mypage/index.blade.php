@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">こんにちは！<b>{{ $user->name  }}</b>さん。</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    読んだ本を探して感想を伝えよう！
                    <hr/> 

                    <div align="center">
                      <form action="/book/search" method="POST">
                      @csrf
                      著者・タイトル
                      <input type="text" name="name" placeholder="本のタイトル・著者名"/>
                      <input type="submit" value="検索" class="submit-button" />
                      @if($errors->has('name'))
                        <tr><th><td><span class="error_mes">{{ $errors->first('name') }}</span></td></tr>
                      @endif
                      </form>
                    </div><!--center -->
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    読んだ本を探して感想を伝えよう！
                    <hr/>
                </div><!-- card-body -->
            </div><!-- card -->
        </div>
    </div><!-- row -->


    <h2><b>{{ $user->name  }}</b> さんのレビュー 一覧</h2>
    @foreach($reviews as $review)
    <div class="row">
      <div class="col-sm-12 col-md-12 col-lg-12">
        <div class="innerbox">
             <a href="/book/search?name={{ str_limit($review->book_title, $limit = 28, $end = '...') }}">
                     <h3 class="card-title">{{ str_limit($review->book_title, $limit = 38, $end = '...') }}</h3>
             </a>
             いいね<span class="badge">14</span>　<a href="/review/comment/show?id={{ $review->id }}">コメント(1)</a>
             <div align="right">
               <button type="button" class="btn btn-success">修正</button>
               　<button type="button" class="btn btn-danger">削除</button>
             </div>
             <hr/>
             <div class="row">
               <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                 <a href="/book/detail?id={{ $review->google_book_id }}&thumbnail={{ $review->thumbnail }}&title={{ $review->book_title }}">
                         <img class="img-thumbnail" src="http://s3.yomuyo.net/books/{{ $review->thumbnail }}" alt="{{ $review->book_title }}">
                 </a>
               </div>
               <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                 {{ $review->comment }}
                 <hr/>
               </div>
             </div><!-- row -->
        </div><!-- innerbos -->
      </div>
    </div><!-- row -->
    @endforeach
    <hr/>
    {{ $reviews->links() }}
</div><!-- container -->






@endsection
