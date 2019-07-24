# 本の書評掲示板 + Google Books APIとのマッシュアップ
---
1. 本番(開発中)：<https://www.yomuyo.net>
2. 解説：<https://www.yuulinux.tokyo/11052/>
---

## Laravel 技術要素
---
*CRUD + Eloquent ORM  済
*リレーション
tinker, hasMany, belogsTo, many to many,
*サービスプロバイダ(DI) 済
*トランザクション, ロールバック 済
*ログイン 済
*システム管理者用ページ
Vue.js + RestAPI(Laravel)で作るかな。
*ソーシャルログイン(Facebook, Twitter) 済
*セッション 済
*アクセス管理 済
*バリデーション 済
*ストレージ + S3連携 済
*try catch + ログ出力 済
*テストコード
*ページネーション 済
*メール送信 済
*イベントとイベントリスナー + AWS SQS
*Artisan make：
auth, request, response, rule, middleware, migrate, seeder, tinker,


## 他技術要素
---
*機密情報隠蔽化：KMS + AWS Systems Manager パラメータグループ 済
*自動デプロイ：Docker => GitHub => CodePipeline => CodeBuild => ECR +ECS 済
*CI + ChatOps：GitHub => CodePipeline => CodeBuild + PHPUnit + [ CloudWatch Events => Lambda+KMS => Slack ] 済
*フレームワーク：Laravel 済
*データベースGUI管理ツール：phpMyAdmin on Docker 済
*言語：PHP7 済
*バッチ処理：Lambda, CloudWatch(定期スナップショット) 済
*RDBMS：RDS(MySQL) 済
*NoSQL：Elasticache for Redis(セッションサーバ, ランキング機能)
*CDN：Laravel + CloudFront + S3 済
*ログ分析基盤：Cloudwatch + S3 + Athena, Elasticsearch+kibana 済
*日時ロギング：CloudWatch Logs(LogGroup)  => Lambda => S3
*DNS：Route53 済
*証明書自動更新：Route53 + ACM + [ ALB|CloudFront ] 済
*メール送信管理：SendGrid 済
*メッセージキュー：Laravel + AWS SQS
*監視：Mackerel => [ Slack|Twilio ], CloudWatch Alert => SNS => Lambda => Slack
*負荷試験：Jmeter, Apache Bench, Locust
*セキュリティ：ELB+AWS WAF(Trend Micro Managed Rules for AWS WAF) 済
*ソーシャルログイン(Laravel Socialite+[Facebook, Twitter]) 済
*マークアップ：HTML/CSS, Bootstrap4, Laravel Blade 済
*ER図 自動作成・更新：SchemaSpy on Docker + Nginx 済
