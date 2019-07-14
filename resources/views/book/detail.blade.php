@extends('layouts.layout')
@section('title', 'サンプルホーム')
@section('content')
 <div class="page-header" class="col-sm-12 col-md-12 col-lg-12">
  <h2><small>検索結果<b>『{{ $post_data }}』</b></small></h2>
 </div>

<?php
    //echo('<pre>');
    //var_dump($paginator);
    //echo('</pre>');
    //exit();
?>

  <div class="flex-container row col-sm-12 col-md-12 col-lg-12">
  @if($books_flag==1)
    @foreach($post_data as $item)


   <div class="card flex-card col-sm-6 col-md-3" >
      @if(isset($item["volumeInfo"]["imageLinks"]["thumbnail"]) )
        <div align="center"><img class="img-thumbnail" src="{{ $item["volumeInfo"]["imageLinks"]["thumbnail"] }}" alt="{{ $item["volumeInfo"]["title"] }}"></div>
      @else
        <div align="center"><img class="img-thumbnail" src="{{ asset('/images/no-image.jpg')  }}" alt="画像"></div>
      @endif
      <div class="card-body">
      @if(isset($item["volumeInfo"]["title"]))
        <a href="/book/search?name={{ str_limit($item["volumeInfo"]["title"], $limit = 20, $end = '...') }}"><h4 class="card-title">{{ str_limit($item["volumeInfo"]["title"], $limit = 20, $end = '...') }}</h4></a>
      @else
        <h4 class="card-title">タイトルなし</h4>
      @endif
      @if(isset($item["volumeInfo"]["authors"][0]))
        <a href="/book/search?name={{ $item["volumeInfo"]["authors"][0] }}"><p class="card-text">{{ str_limit($item["volumeInfo"]["authors"][0], $limit = 20, $end = '...') }}</p></a>
      @else
        <p class="card-text">作者名なし</p>
      @endif
        <a href="#" class="btn btn-primary">登録</a> <a href="#" class="btn btn-default">Amazonで購入</a>
      </div><!-- card-body -->
   </div><!-- card flex-card -->

    @endforeach
  </div><!-- /.flex-container -->


  @else($books_flag==0)
 <div class="page-header" class="col-sm-12 col-md-12 col-lg-12">
   <h2>書籍データがないようです。ごめんなさい。</h2>
 </div>
  @endif

@endsection
