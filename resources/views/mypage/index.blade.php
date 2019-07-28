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



<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header"></div>

                <div class="card-body">
@if(isset($item["title"]))
  <div class="flex-container row col-sm-12 col-md-12 col-lg-12">
   <div class="card flex-card col-sm-6 col-md-3 col-lg-3" >
      @if( isset($item["thumbnail"]) )
        <div align="center"><a href="https://www.amazon.co.jp/s?k={{ $item["title"] }}" target="_blank" ><img class="img-thumbnail" src="{{ $item["thumbnail"] }}&printsec=frontcover&img=1&zoom=1&edge=curl&source=gbs_api" alt="{{ $item["title"] }}"></a></div>
      @else
        <div align="center"><img class="img-thumbnail" src="{{ asset('/images/no-image.jpg')  }}" alt="画像"></div>
      @endif
      <div class="card-body">
      @if(isset($item["title"]))
        <a href="/book/search?name={{ str_limit($item["title"], $limit = 20, $end = '...') }}"><h4 class="card-title">{{ $item["title"] }}</h4></a>
      @else
        <h4 class="card-title">タイトルなし</h4>
      @endif
        <a href="https://www.amazon.co.jp/s?k={{ $item["title"] }}" target="_blank" class="btn btn-primary">Amazonで購入</a>
      </div><!-- card-body -->
   </div><!-- card flex-card -->

<div class="card col-sm-12 col-md-8 col-sm-8" style="margin-left: 5px; ">
  <h2><strong>『{{ $item["title"] }} 』</strong>の感想を投稿</h2>

  <div class="row">
    <div class="col-lg-12">
      <form action="/mypage/post" method="POST">
      @csrf
        <input type="hidden" name="google_book_id" value="{{ $item["id"] }}"> 
        <input type="hidden" name="title" value="{{ $item["title"] }}">
        <input type="hidden" name="thumbnail" value="{{ $item["thumbnail"] }}">
        <div class="textarea">
          <label>
            <textarea name="comment" class="form-control" rows="10" cols="200" id="focusedInput" placeholder="ここに感想を書いてください。"/></textarea>
            <input type="checkbox" name="netabare_flag" >ネタばれ<span style="font-size: 12px;">(ネタばれが含まれる感想はチェックをお願いします。)</span>
          </label>
        </div>
        <div class="submmit" align="center">
          <label>
            <button type="submit" class="btn btn-primary submit-button">投稿する</button>
          </label>
        </div>
      </form>
    </div>
  </div>
</div>


                </div>
            </div>
        </div>
    </div>
</div>
@endif



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
