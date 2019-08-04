



$(function(){
    $('.btn-nice').click(function(event){
        // ページ遷移をキャンセル
        event.stopPropagation();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var $this = $(this);
        var review_id = $this.parent('.post').data('review_id');

        // Ajax設定
        $.ajax({
                    type:     'POST',
                    datatype: 'json',
                    url:      '/nice/create',
                    timeout:  10000,
                    data: {
                              _token:    CSRF_TOKEN, // CSRFトークン
                              review_id: review_id   // reviws.id レビューID
                          }
        })
        // Ajax成功時の処理
        .done(function(data){
                    console.log("Ajax Success!");
                    
        })
        // Ajax通信失敗時の処理
        .fail(function(data){
                    console.log('Ajax Error');
        });
    });
});


