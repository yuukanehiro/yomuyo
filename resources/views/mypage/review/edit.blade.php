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
                    <hr/>
                </div><!-- card-body -->
            </div><!-- card -->
        </div>
    </div><!-- row -->
</div>



<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header"></div>

                <div class="card-body">

@if(isset($item->book_title))
  <div class="flex-container row col-sm-12 col-md-12 col-lg-12">
   <div class="card flex-card col-sm-6 col-md-3 col-lg-3" >
      @if( isset($item->thumbnail) )
        <div align="center"><a href="https://www.amazon.co.jp/s?k={{ $item->book_title }}" target="_blank" ><img class="img-thumbnail" src="{{ $thumbnail_url }}" alt="{{ $item->book_title }}"></a></div>
      @else
        <div align="center"><img class="img-thumbnail" src="{{ asset('/images/no-image.jpg')  }}" alt="画像"></div>
      @endif
      <div class="card-body">
      @if(isset($item->book_title))
        <a href="/book/search?name={{ str_limit($item->book_title, $limit = 20, $end = '...') }}"><h4 class="card-title">{{ $item->book_title }}</h4></a>
      @else
        <h4 class="card-title">タイトルなし</h4>
      @endif
        <a href="https://www.amazon.co.jp/s?k={{ $item->book_title }}" target="_blank" class="btn btn-primary">Amazonで購入</a>
      </div><!-- card-body -->
   </div><!-- card flex-card -->

<div class="card col-sm-12 col-md-8 col-sm-8" style="margin-left: 5px; ">
  <h2><strong>『{{ $item->book_title }} 』</strong>の感想を投稿</h2>

  <div class="row">
    <div class="col-lg-12">
      <form action="/mypage/review/edit" method="POST">
      @csrf
        <input type="hidden" name="google_book_id" value="{{ $item->id }}">
        <input type="hidden" name="title" value="{{ $item->book_title }}">
        <input type="hidden" name="thumbnail" value="{{ $item->thumbnail }}">
        <input type="hidden" name="id" value="{{ $item->id }}">
        <div class="textarea">
          <label>
            <textarea name="comment" class="form-control" rows="10" cols="200" id="focusedInput" placeholder="ここに感想を書いてください。"/>{{ $item->comment }}</textarea>
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


@endsection
