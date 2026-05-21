# アプリ名
take-freemarket

## 環境構築手順
リポジトリからダウンロード

```git clone git@github.com:Estra-Coachtech/laravel-docker-template.git```

上記コマンドでコーチテックのGitHubからlaravel-docker-template.gitに開発環境をコピーします。

```mv laravel-docker-template take-freemarket```
 
上記コマンドでlaravel-docker-templateから　take-freemarketに名前を変更します。名前はその時々で最適なものを選びましょう。
続いて、GitHubでその名前のリモートリポジトリを作成します。
作成したリポジトリからurlを取得して次のコマンドを入力します。

```git remote set-url origin 作成したリポジトリのurl```

次に現在のローカルリポジトリの内容をリモートリポジトリに反映させます。具体的なコマンドは以下です。

```git add .```
```git commit -m "リモートリポジトリの変更"```
```git push origin main```

エラーが発生する場合は以下のコマンドを試してみましょう。(passwordが必要)
```sudo chmod -R 777 *```

Dockerの設定

```docker-compose up -d --build```

LARAVELのパッケージのインストール
以下のコマンドでPHPコンテナ内にログインしましょう。この時Dockerを立ち上げるのを忘れないように。

```docker-compose exec php bash```

以下のコマンドでcomposerをinstallします
```composer install```

.envファイルの作成

PHPコンテナ内で以下のコマンドを実行します。これは.env.exampleを.envファイルにコピーしています。
```cp .env.example .env```

.envファイルの１１行目以下を以下のように変更します。
```DB_HOST=mysqlDB_DATABASE=laravel_dbDB_USERNAME=laravel_userDB_PASSWORD=laravel_pass```

日本時間の設定

プロジェクト内config内のapp.phpの７０行目あたりにある'timezone'の設定を世界標準時であるUTCから日本時間である'Asia/Tokyo'へ変更します。

以上で環境構築は終了となります。

###　シーディング

PHPコンテナ内で以下のコマンドを実行します。

```php artisan seed```

これで商品のカテゴリと初期商品とテストユーザー１と２のデータがシーディングされます。

####　テストプログラム環境構築
テスト用データベースの作成

```mysql -u root -p```　

コマンドでルート権限でmysqlにログインし、

```CREATE DATABASE demo_test;```

コマンドでdemo_testというテスト用データベースを作成します。

configファイルの変更

次にconfigディレクトリの中のdatabase.phpを開きmysqlの配列部分をコピーしmysql_testを作成し、項目のうち、databaseをdemo_testに、usernameとpasswordをそれぞれrootに変更します。

テスト用.envファイルの作成

phpコンテナにログインし、

```cp .env .env.testing```

コマンドで.envファイルをコピーしたenv.testingというファイルを作成します。

ファイルの作成ができたら文頭部分のAPP_ENVをTESTにAPP_KEYを空白にします。

次にenv.testingにテスト用のデータベースの接続情報を加えます。

具体的にはDB_DATABASEをdemo_testDB_USERNAMEおよびDB_PASSWORDをrootに変更します。

次に先ほど空にしたAPP_KEYに新たなテスト用のアプリケーションキーを加えるためphpコンテナ内で下記のコマンドを実行します。

```php artisan key:generate --env=testing```

　次に、マイグレーションコマンドを実行して、テスト用のテーブルを作成します。コマンドは以下です。

```php artisan migrate --env=testing```

phpunitの編集

プロジェクトの直下のphpunit.xmlを開き、DB_CONNECTIONとDB_DATABASEを以下のように変更します。
```DB_CONNECTION　"mysql_test"```
```DB_DATABASE　　"demo_test"```

以上でテストプログラムを動作するための環境作成は終了です。


##### テストプログラム実行

PHPコンテナ内で以下のコマンドを実行します。

```php artisan test```

各テストの成否が表示されます。


###### 使用技術
```PHP 8.1.34```       

```Laravel Framework 8.83.8```    

```Composer version 2.9.3 ```  

```mysql:8.0.26 ```   

```nginx:1.21.1 ```   