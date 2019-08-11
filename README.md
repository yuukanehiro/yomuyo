# 本の書評掲示板 + Google Books APIとのマッシュアップ
![Yomuyo ポートフォリオ作品](https://www.yuulinux.tokyo/contents/wp-content/uploads/2019/08/yomuyo_20190812_1_r2.png "Yomuyo")
---
![Yomuyo ポートフォリオ作品](https://www.yuulinux.tokyo/contents/wp-content/uploads/2019/06/yomuyo_20190805_1.png "Yomuyo")
---
1. 本番：<https://www.yomuyo.net>
2. 開発記録：   
    その1. <https://www.yuulinux.tokyo/11052/>  
    その2. <https://www.yuulinux.tokyo/12504/>  
    その3. <https://www.yuulinux.tokyo/12554/>  
---

## Laravel 技術要素
---
* 【DB】CRUD + Eloquent ORM  済
* 【DB】リレーション, アソシエーション 済  
        tinker, hasMany, belogsTo, many to many  
* 【DB】つぶやきデータのパーティショニング  
* 【DB】トランザクション, ロールバック 済
* 【DB】フォロー, 被フォロー 
* 【NoSQL】オブジェクトキャッシュ, キャッシュパージ機能 済
* サービスプロバイダ(DI) 済
* ログイン 済
* いいねボタン：Ajax + jQuery + JSON 済
* ソーシャルログイン(Facebook, Twitter) 済
* セッション 済
* アクセス管理 済
* バリデーション 済
* ストレージ + S3連携 済
* try catch + ログ出力 済
* ページネーション 済
* メール送信 済 
* テストコード  
* システム管理者用ページ
  Vue.js + RestAPI(Laravel)で作る？  
* イベントとイベントリスナー + AWS SQS
* Artisan
  auth, request, response, rule, middleware, migrate, seeder, tinker 済  



## 他技術要素
---
* 機密情報隠蔽化：KMS + AWS Systems Manager パラメータグループ 済
* 自動デプロイ：Docker => GitHub => CodePipeline => CodeBuild => ECR +ECS 済
* CI + ChatOps：GitHub => CodePipeline => CodeBuild + PHPUnit + [ CloudWatch Events => Lambda+KMS => Slack ] 済
* フレームワーク：Laravel 済
* データベースGUI管理ツール：phpMyAdmin on Docker 済
* 言語：PHP7 済
* バッチ処理：Lambda, CloudWatch(定期スナップショット) 済
* RDBMS：RDS(MySQL) 済
* NoSQL：Elasticache for Redis(セッションサーバ, オブジェクトキャッシュ) 済
* CDN + Laravel連携：ACM + CloudFront + S3 + Laravel(画像アップロード/配信) 済
* ログ分析基盤：Cloudwatch + S3 + Athena, Elasticsearch+kibana 済
* 日時ロギング：CloudWatch Logs(LogGroup)  => Lambda => S3
* DNS：Route53 済
* 証明書自動更新：Route53 + ACM + [ ALB|CloudFront ] 済
* メール送信管理：SendGrid 済
* メッセージキュー：Laravel + AWS SQS
* 監視：Mackerel => [ Slack|Twilio ], CloudWatch Alert => SNS => Lambda => Slack
* 負荷試験：Jmeter, Apache Bench, Locust
* セキュリティ：ELB+AWS WAF(Trend Micro Managed Rules for AWS WAF) 済
* ソーシャルログイン(Laravel Socialite+[Facebook, Twitter]) 済
* マークアップ：HTML/CSS, Bootstrap4, Laravel Blade 済
* ER図 自動作成・更新：SchemaSpy on Docker + Nginx 済



## 苦労した点
---
* いいねボタン  
  Ajaxでのpostが開発環境では動作するが、本番環境では動作せずはまった。  
  本番はALB配下なので動作が異なった。ドメイン、IP、URIに依存せずにPOSTする仕様にする必要があった。    
  解決として、  
  ・パスとコントローラのルーティングを修正することで対応しました。  
  　<https://github.com/yuukanehiro/yomuyo/issues/12>
* Google Books API選定までの苦労  
  Amazon PA APIを当初利用していたが、PA APIは事前の売上審査が通るまでAPIを利用できない仕様だということを知らず、コーディングの実装が悪いのか？と半日ほど進捗が止まってしまった。  
  えいやっとGoogle Books API利用であっさり実装。  
  改善として、  
  ・外部サービスを利用する場合はよく調べる。  
  ・実装しやすい技術選定を行う。  
* 初期の名前設定による負債  
  初期の名前設定が曖昧でががっと進めた為バグの温床になり後に苦しんだ。  
  解決として、  
  命名規則を自分の中でしっかりもつ  
  ・リクエストの受け取りは$itemにする。  
  ・DBから取得したオブジェクトは【$ranks】, 【$reviews】などわかる名前にする。  
  ・パラメータを安易に決めない。わかる名前にする  
    idやnameでは何のidや名前なのかわからない。  
    review_id, book_title, user_nameなどわかるものにする。  




