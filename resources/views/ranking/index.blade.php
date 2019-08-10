@extends('layouts.top')
@section('title', 'Youmuyoへようこそ')
@section('content')
 <div class="page-header" style="margin-top:-30px;padding-bottom:0px;">
           <h2 class="top-title">Yomuyo -自分を変えた1冊を共有しよう-</h2>
 </div>


  
 <div class="top-title col-sm-12 col-md-12 col-lg-12" style=" width: 100%;">
  <h2>みんなが読んでる本 <br/><img src="{{ asset('/images/ranking_r1.gif')  }}">デイリーランキング
  </h2>
 </div>

  <div class="flex-container row col-sm-12 col-md-12 col-lg-12">
    @php $i = 1; @endphp
    @foreach($ranks as $rank)

   <div class="card flex-card col-sm-6 col-md-2" >
      @if(isset($rank->thumbnail) )
        <div align="center">
          <a href="/book/detail?id={{ $rank->google_book_id }}&thumbnail={{ $rank->thumbnail }}&title={{ $rank->book_title }}&google_book_id={{ $rank->google_book_id }}">
                <span class="rank_num">{{ $i }}</span>
                         <img class="img-thumbnail" src="https://s3.yomuyo.net/books/{{ $rank->thumbnail }}" alt="{{ $rank->book_title }}">
          </a>
        </div>
      @else
        <div align="center"><img class="img-thumbnail" src="{{ asset('/images/no-image.jpg')  }}" alt="画像"></div>
      @endif
      <div class="card-body">

      @if(isset($rank->book_title))
        <a href="/book/search?name={{ str_limit($rank->book_title, $limit = 12, '') }}">
              <h4 class="card-title">{{ str_limit($rank->book_title, $limit = 28, $end = '...') }}</h4>
        </a>
      @else
        <h4 class="card-title">タイトルなし</h4>
      @endif
        <a href="/mypage?id={{ $rank->google_book_id }}&thumbnail={{ $rank->thumbnail }}&title={{ $rank->book_title }}" class="btn btn-primary">登録</a>
        　<a href="https://www.amazon.co.jp/s?k={{ $rank->book_title }}" target="_blank" class="btn btn-default">Amazonで購入</a>
      </div><!-- card-body -->
   </div><!-- card flex-card -->
      @php $i++ @endphp
    @endforeach
    <hr/>
  </div><!-- /.flex-container -->





  <div class="top-title col-sm-12 col-md-12 col-lg-12" style=" width: 100%;">
  <h2>いいねが多い本 <br/><img src="{{ asset('/images/ranking_r1.gif')  }}">デイリーランキング
  </h2>
 </div>




  <div class="flex-container row col-sm-12 col-md-12 col-lg-12">
    @php $i = 1; @endphp
    @foreach($ranks_nice as $rank‗nice)

   <div class="card flex-card col-sm-6 col-md-2" >
      @if(isset($rank‗nice->thumbnail) )
        <div align="center">
          <a href="/book/detail?id={{ $rank‗nice->google_book_id }}&thumbnail={{ $rank‗nice->thumbnail }}&title={{ $rank‗nice->book_title }}&google_book_id={{ $rank‗nice->google_book_id }}">
                <span class="rank_num">{{ $i }}</span>
                         <img class="img-thumbnail" src="https://s3.yomuyo.net/books/{{ $rank‗nice->thumbnail }}" alt="{{ $rank‗nice->book_title }}">
          </a>
        </div>
      @else
        <div align="center"><img class="img-thumbnail" src="{{ asset('/images/no-image.jpg')  }}" alt="画像"></div>
      @endif
      <div class="card-body">

      @if(isset($rank‗nice->book_title))
        <a href="/book/search?name={{ $rank‗nice->book_title }}">
              <h4 class="card-title">{{ str_limit($rank‗nice->book_title, $limit = 28, $end = '...') }}</h4>
        </a>
      @else
        <h4 class="card-title">タイトルなし</h4>
      @endif
        <a href="/mypage?id={{ $rank‗nice->google_book_id }}&thumbnail={{ $rank‗nice->thumbnail }}&title={{ $rank‗nice->book_title }}" class="btn btn-primary">登録</a>
        　<a href="https://www.amazon.co.jp/s?k={{ $rank‗nice->book_title }}" target="_blank" class="btn btn-default">Amazonで購入</a>
      </div><!-- card-body -->
   </div><!-- card flex-card -->
      @php $i++ @endphp
    @endforeach
    <hr/>
  </div><!-- /.flex-container -->
@endsection
