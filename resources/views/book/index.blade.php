@extends('layouts.layout')
@section('title', 'サンプルホーム')
@section('content')
 <div class="page-header" style="margin-top:-30px;padding-bottom:0px;">
  <!-- <h1><small>Yomuyo -自分を変えた一冊を共有しよう-</small></h1> -->
  <h2 class="top-title">Yomuyo -自分を変えた一冊を共有しよう-</h2>
 </div>

 <div class="top_image">
  <img src="{{ asset('/images/19212klzds_TP_V.jpg') }}">
  <p>最高の本を伝える<br/>
  新しい本に出会う</p>
 </div>


<br/>
<br/>

 <div class="page-header" style="margin-top:-30px;padding-bottom:0px;">
  <h2>みんなの投稿</h2>
 </div>


@endsection
