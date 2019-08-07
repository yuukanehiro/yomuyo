@extends('layouts.layout')
@section('title', '本の検索結果')
@section('content')
 <div class="page-header" class="col-sm-12 col-md-12 col-lg-12">
   <h2><small>検索結果<b>『{{ $post_data }}』</b></small></h2>
 </div>

  <div class="flex-container row col-sm-12 col-md-12 col-lg-12">
  @if($books_flag==1)
    @foreach($paginatedItems as $item)

      <!-- Google Books Thumnail取得 -->
      @php
          $thumbnail = "https://books.google.com/books?id=".$item["id"]."&printsec=frontcover&img=1&zoom=5&edge=curl&source=gbs_api";
      @endphp

   <div class="card flex-card col-sm-6 col-md-3" >
      @if(isset($item["volumeInfo"]["imageLinks"]["thumbnail"]) )
        <div align="center">
          <a href="/book/detail?id={{ $item["id"] }}&thumbnail={{ $thumbnail }}&title={{ $item["volumeInfo"]["title"] }}">
            <img class="img-thumbnail" src="{{ $thumbnail }}" alt="{{ $item["volumeInfo"]["title"] }}">
          </a>
        </div>
      @else
        <div align="center">
          <img class="img-thumbnail" src="{{ asset('/images/no-image.jpg')  }}" alt="画像">
        </div>
      @endif
      <div class="card-body">
      @if(isset($item["volumeInfo"]["title"]))
        <a href="/book/search?name={{ str_limit($item["volumeInfo"]["title"], $limit = 40) }}">
              <h4 class="card-title">{{ str_limit($item["volumeInfo"]["title"], $limit = 28, $end = '...') }}</h4>
        </a>
      @else
        <h4 class="card-title">タイトルなし</h4>
      @endif
        <a href="/mypage?id={{ $item["id"] }}&thumbnail={{ $thumbnail }}&title={{ $item["volumeInfo"]["title"] }}" class="btn btn-primary">登録</a>
        　<a href="https://www.amazon.co.jp/s?k={{ $item["volumeInfo"]["title"] }}" target="_blank" class="btn btn-default">Amazonで購入</a>
      </div><!-- card-body -->
   </div><!-- card flex-card -->


    @endforeach
  </div><!-- /.flex-container -->




    {{ $paginatedItems->appends($post_data)->render() }}


  @else($books_flag==0)
 <div class="page-header" class="col-sm-12 col-md-12 col-lg-12">
   <h2>書籍データがないようです。ごめんなさい。</h2>
 </div>
  @endif



@endsection
