# アプリ名　FREEMA

## 環境構築手順
①リポジトリの設定
　git clone git@github.com:Estra-Coachtech/laravel-docker-template.git
上記コマンドでコーチテックのGitHubからlaravel-docker-template.gitに開発環境をコピーします。
 mv laravel-docker-template take-freemarket
上記コマンドでlaravel-docker-templateから　take-freemarketに名前を変更します。名前はその時々で最適なものを選びましょう。
続いて、GitHubでその名前のリモートリポジトリを作成します。

作成したリポジトリからurlを取得して次のコマンドを入力します。
　git remote set-url origin 作成したリポジトリのurl
　
次に現在のローカルリポジトリの内容をリモートリポジトリに反映させます。具体的なコマンドは以下です。
　git add .
　git commit -m "リモートリポジトリの変更"
　git push origin main
エラーが発生する場合は以下のコマンドを試してみましょう。(passwordが必要)
　sudo chmod -R 777 *

②Dockerの設定
以下のコマンドを入力します。
　docker-compose up -d --build

③LARAVELのパッケージのインストール
以下のコマンドでPHPコンテナ内にログインしましょう。この時Dockerを立ち上げるのを忘れないように。
　docker-compose exec php bash
以下のコマンドでcomposerをinstallします
　composer install
④.envファイルの作成
PHPコンテナ内で以下のコマンドを実行します。これは.env.exampleを.envファイルにコピーしています。
　cp .env.example .env
.envファイルの１１行目以下を以下のように変更します。
　DB_HOST=mysql

　DB_DATABASE=laravel_db
　DB_USERNAME=laravel_user
　DB_PASSWORD=laravel_pass
