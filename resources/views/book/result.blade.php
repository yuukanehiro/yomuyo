@extends('layouts.layout')
@section('title', 'サンプルホーム')
@section('content')
 <div class="page-header" style="margin-top:-30px;padding-bottom:0px;">
  <h1><small>検索結果『{{ $post_data['name'] }}』</small></h1>
 </div>

<?php
    //echo('<pre>');
    //var_dump($json_decode['items']);
    //echo('</pre>');
    //exit();
?>

 @foreach($json_decode['items'] as $item)

     @if(isset($item["volumeInfo"]["title"][0]))
         {{ $item["volumeInfo"]["title"][0] }}<br/>
     @else
         著書名なし<br/>
     @endif

     @if(isset($item["volumeInfo"]["authors"][0]))
         {{ $item["volumeInfo"]["authors"][0] }}<br/>
     @else
         著者データなし<br/>
     @endif

     @if(isset($item["volumeInfo"]["imageLinks"]["thumbnail"]) )
         <img src="{{ $item["volumeInfo"]["imageLinks"]["thumbnail"] }}" ><br/>
     @else
         <img src="{{ asset('/images/no-image.jpg')  }}"><br/>
     @endif

     @if( isset($item["volumeInfo"]["description"]) )
         {{ $item["volumeInfo"]["description"] }}<br/>
     @endif
     {{ $item["id"] }}
     <hr/>
 @endforeach

@endsection
