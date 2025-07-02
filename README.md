fleamarket 環境構築

＃　クローンを作成
　　　git clone git@github.com:coachtech-material/laravel-docker-template.gitクローンを作成
＃　Dockerの起動
　　　docker compose up -d --build
＃　PHPコンテナに入る
　　　docker compose exec php bash

 　fleamarket上のsrcで行うこと
＃　.env作成
　　　cp .env.local .env

   PHPコンテナ内で行うこと
＃アプリケーションキー作成
　　php artisan key:generate
＃データベース作成
　　php artisan migrate --seed
   
　　　
