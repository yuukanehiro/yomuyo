@extends('layouts.layout')
@section('title', 'サンプルホーム')
@section('content')




  <div class="flex-container row col-sm-12 col-md-12 col-lg-12">
            <div class="card flex-card col-xs-12 col-sm-12 col-md-3 col-lg-3" >
                @if(isset($item["thumbnail"]) )
                    <div align="center">
                    <a href="/mypage?id={{ $item["id"]  }}&thumbnail={{ $thumanil_url }}&title={{ $item["title"] }}">
                            <img class="img-thumbnail" src="{{ $thumanil_url }}" alt="{{ $item["title"] }}">
                    </a>
                    </div>
                @else
                    <div align="center">
                            <img class="img-thumbnail" src="{{ asset('/images/no-image.jpg')  }}" alt="画像">
                    </div>
                @endif
                    <div class="card-body">
                @if(isset($item["title"]))
                        <a href="/book/search?name={{ str_limit($item["title"], $limit = 20, $end = '...') }}">
                            <h4 class="card-title">{{ $item["title"] }}</h4>
                        </a>
                @else
                        <h4 class="card-title">タイトルなし</h4>
                @endif
                        <a href="/mypage?id={{ $item["id"]  }}&thumbnail={{ $thumanil_url }}&title={{ $item["title"] }}" class="btn btn-primary">登録</a>
                        　<a href="https://www.amazon.co.jp/s?k={{ $item["title"] }}" target="_blank" class="btn btn-default">Amazonで購入</a>
                        <hr/>
                    </div><!-- card-body -->
            </div><!-- card flex-card -->


            <div class="card col-xs-12 col-sm-12 col-md-9 col-lg-9" >
                <h2>{{ $review->user_name }} さんの 『{{ $review->book_title }}』感想</h2>  

                @if(isset($review->book_title))
                    <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                                <div class="innerbox">
                                    <img src="{{ asset('/images/profile_default_icon.gif') }}"> {{ $review->user_name }} さん 　いいね<span class="badge">14</span>
                                    <a href="/comment/?id={{ $item["id"]  }}&thumbnail={{ $thumanil_url }}&title={{ $item["title"] }}">
                                            <span style="font-size: 1.2rem;">コメント(1)</span>
                                    </a>
                                    <hr/>
                                    {{ $review->comment }}
                                    <hr/>
        　　  　       　　            <form>
                                        @csrf
                                        <div class="form-group">
                                                <textarea name="res" rows="2" class="form-control" style="font-size: 18px;" placeholder="ここにコメントを書いてください。"></textarea>
                                        </div>
                                        <div class="form-group">
                                                <button type="submit" class="btn btn-primary" >コメントする</button>
                                        </div>
                                    </form>
                                </div><!-- innerbox -->
                            </div><!--col -->
                    </div><!-- row -->
                @else
                    <div class="row">
                        <h3>
                                <p>まだ感想がありません。</p>
                                <p>
                                    <a href="/mypage?id={{ $item["id"]  }}&thumbnail={{ $thumbnail_url }}&title={{ $item["title"] }}" class="btn btn-primary">この本の感想を投稿する</a>
                                </p>
                        </h3>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style=" width: 100%;">
                                    <!-- {{ $reviews->appends(request()->input())->links() }} -->
                            </div>
                    </div><!-- row -->
                @endif



 
                <div class="card col-xs-12 col-sm-12 col-md-12 col-lg-12" >

                    <h2>みんなのコメント</h2>  
                    @if($comments->isEmpty() == false)
                            @foreach($comments as $comment)
                                    <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                                                <div class="innerbox">
                                                    <img src="{{ asset('/images/profile_default_icon.gif') }}"> {{ $comment->user_name }} さん 　いいね<span class="badge">14</span>
                                                            　<a href="/review/comment/show?id={{ $review->id }}">
                                                            <span style="font-size: 1.2rem;">コメント(1)</span>
                                                    </a>
                                                    <hr/>
                                                    {{ $comment->comment }}
                                                    <hr/>
                        　　  　       　　            <form>
                                                        @csrf
                                                        <div class="form-group">
                                                                <textarea name="res" rows="2" class="form-control" style="font-size: 18px;" placeholder="ここにコメントを書いてください。"></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                                <button type="submit" class="btn btn-primary" >コメントする</button>
                                                        </div>
                                                    </form>
                                                </div><!-- innerbox -->
                                            </div><!--col -->
                                    </div><!-- row -->
                            @endforeach

                            <div class="row"> 
                                <div class="col-sm-12 col-md-12 col-lg-12" style=" width: 100%;">
                                        {{ $comments->appends(request()->input())->links() }}
                                </div>
                            </div>
                    @else
                            <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                                        <div class="innerbox">
                                <h3>
                                        <p>まだコメントはありません。</p>
                                </h3>
                                        </div><!-- innerbox -->
                                    </div><!--col -->
                            </div><!-- row -->
                    @endif

                </div><!--card -->


  </div><!-- flex-container row-->

@endsection

