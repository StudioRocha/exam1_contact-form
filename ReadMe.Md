# 確認テスト\_お問い合わせフォーム

## 環境構築

**Docker ビルド**

1. `git@github.com:StudioRocha/exam1_contact-form.git`
2. `docker-compose up -d --build`

※補足: MySQL は OS によって起動しない場合があるため、各 PC に合わせて docker-compose.yml を編集してください。

**Laravel 環境構築**

1. `docker-compose exec php bash`
2. `composer install`

3. .env.example から .env を作成し、環境変数を設定
4. .env に以下の環境変数を追加

```text
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass
```

5. アプリケーションキーの作成

```bash
php artisan key:generate
```

6. マイグレーションの実行

```bash
php artisan migrate
```

7. シーディングの実行

    .contacts テーブルにダミーデータを 35 件作成

    .categories テーブル(お問い合わせの種類)のダミーデータはシーダーファイルを使用し、以下５件のダミーデータを作成

    - 商品のお届けについて
    - 商品の交換について
    - 商品トラブル
    - ショップへのお問い合わせ
    - その他

```bash
php artisan db:seed
```

<BR>
<BR>

![Warning](https://img.shields.io/badge/Warning-Permission%20denied-red)
Windows WSL 環境ではファイル権限のエラーが出る場合があります。
ブラウザでlocalhost接続時に "Permission denied"というエラーが発生した場合は、
このプロジェクトのroot ディレクトリで下記のコマンドを実行して再接続して下さい。


```bash
$ sudo chmod -R 777 src/*
```

## 使用技術(実行環境)

-   php:8.1-fpm
-   Laravel 8.83.8
-   MySQL 8.0.26

## ER 図

<img src="docs/images/ER.svg" width="640" alt="ER図">

ソース（編集用）: [docs/ER.dio]

## URL

-   開発環境：http://localhost/
-   phpMyAdmin:：http://localhost:8080/
