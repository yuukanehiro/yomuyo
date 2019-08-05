

$(function(){
    $('.btn-nice').click(function(event){
        // ページ遷移をキャンセル
        event.stopPropagation();

        // CSRFトークンの取得 
        $.ajaxSetup({
            timeout: 3000,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // 変数設定
        var CSRF_TOKEN    = $('meta[name="csrf-token"]').attr('content');
        var $this         = $(this);
        var review_id     = $this.parent('.post').data('review_id');
        var login_user_id = $this.parent('.post').data('login_user_id');
        //var url_root      = $this.parent('.post').data('url_root');

        // Ajax設定 ============================================================================
        $.ajax({
                    type:     'POST',
                    datatype: 'json',
                    url:      './nice/create',
                    timeout:  3000,
                    data: {
                              _token:    CSRF_TOKEN,       // CSRFトークン
                              review_id: review_id,        // reviws.id レビューID
                              login_user_id: login_user_id // いいねを押したログインユーザのID
                          }
        })
        // Ajax成功時の処理 ===========================
        .done(function(data){
                    console.log("Ajax Success!");
            
                    // いいねの総数を表示
                    $this.children('span').html(data);
                    // いいね取り消しのスタイル
                    $this.children('i').toggleClass('far'); //空洞ハート
                    // いいね押した時のスタイル
                    $this.children('i').toggleClass('fas'); //塗りつぶしハート
                    $this.children('i').toggleClass('active');
                    $this.toggleClass('active');
        })
        // Ajax通信失敗時の処理 ========================
        .fail(function(data){
                    console.log('Ajax Error');
        });
    });
});


