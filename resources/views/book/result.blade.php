@extends('layouts.layout')
@section('title', 'サンプルホーム')
@section('content')
 <div class="page-header" style="margin-top:-30px;padding-bottom:0px;">
  <h2><small>検索結果『{{ $post_data['name'] }}』</small></h2>
 </div>

<?php
    //echo('<pre>');
    //var_dump($json_decode['items']);
    //echo('</pre>');
    //exit();
?>

 @foreach($json_decode['items'] as $item)
<div class="row">
  <div class="col-sm-6 col-md-3">
    <div class="card img-thumbnail">
      <div align="center">
      @if(isset($item["volumeInfo"]["imageLinks"]["thumbnail"]) )
          <img class="card-img-top" src="{{ $item["volumeInfo"]["imageLinks"]["thumbnail"] }}" alt="画像">
      @else
          <img class="card-img-top" src="{{ asset('/images/no-image.jpg')  }}" alt="画像">
      @endif
      </div><!-- center -->
      <div class="card-body px-2 py-3">
      @if(isset($item["volumeInfo"]["title"]))
        <p class="card-text">{{ $item["volumeInfo"]["title"] }}</p>
      @else
        <p class="card-text">著書名なし</p>
      @endif
      @if(isset($item["volumeInfo"]["authors"][0]))
        <a href="#"><h5 class="card-title">{{ $item["volumeInfo"]["authors"][0] }}</h5></a>
      @else
        <h5 class="card-title">著者データなし</h5>
      @endif
        <p class="mb-0">
         <a href="#" class="btn btn-primary btn-sm">登録</a>
         <a href="#" class="btn btn-primary btn-sm">Amazonで購入</a>
        </p>

      </div><!-- /.card-body -->
    </div><!-- /.card -->
  </div><!-- /.col-sm-6.col-md-3 -->
</div><!-- /.row -->
 @endforeach

@endsection
