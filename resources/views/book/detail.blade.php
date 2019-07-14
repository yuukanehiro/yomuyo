@extends('layouts.layout')
@section('title', 'サンプルホーム')
@section('content')


  <div class="flex-container row col-sm-12 col-md-12 col-lg-12">
   <div class="card flex-card col-sm-6 col-md-3 col-lg-3" >
      @if(isset($item["thumbnail"]) )
        <div align="center"><a href="/book/detail?thumbnail={{ $item["thumbnail"] }}&title={{ $item["title"] }}"><img class="img-thumbnail" src="{{ $item["thumbnail"] }}&printsec=frontcover&img=1&zoom=1&edge=curl&source=gbs_api" alt="{{ $item["title"] }}"></a></div>
      @else
        <div align="center"><img class="img-thumbnail" src="{{ asset('/images/no-image.jpg')  }}" alt="画像"></div>
      @endif
      <div class="card-body">
      @if(isset($item["title"]))
        <a href="/book/search?name={{ str_limit($item["title"], $limit = 20, $end = '...') }}"><h4 class="card-title">{{ $item["title"] }}</h4></a>
      @else
        <h4 class="card-title">タイトルなし</h4>
      @endif
        <a href="#" class="btn btn-primary">登録</a> <a href="https://www.amazon.co.jp/s?k={{ $item["title"] }}" target="_blank" class="btn btn-default">Amazonで購入</a>
      </div><!-- card-body -->
   </div><!-- card flex-card -->

<div class="card col-sm-6 col-md-9 col-sm-9" >
  <h2>みんなの感想・レビュー</h2>  
</div>

  </div><!-- flex-container -->



@endsection

