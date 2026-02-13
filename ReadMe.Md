# 確認テスト\_お問い合わせフォーム

## 環境構築

**Docker ビルド**

1. `git@github.com:StudioRocha/exam1_contact-form.git`
2. `docker-compose up -d --build`

※補足: MySQL は OS によって起動しない場合があるため、各 PC に合わせて docker-compose.yml を編集してください。

**Laravel 環境構築**

1. コマンドライン上
```bash
 docker-compose exec php bash
```
2. PHPコンテナ上
```bash
 composer install
```

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

    .users テーブルに管理者のダミーユーザーを 1 件作成（管理画面ログイン用）

    - メールアドレス: **dev@example.com**
    - パスワード: **password**

```bash
php artisan db:seed
```

<BR>


![Warning](https://img.shields.io/badge/Warning-Permission%20denied-red)
UnexpectedValueException ページエラーが出た場合

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

## 画面一覧

| 画面名 | URL / ルート名 | 説明 | 認証 |
|--------|----------------|------|------|
| お問い合わせ入力 | GET `/` (home) | お問い合わせフォームの入力画面 | 不要 |
| お問い合わせ確認 | POST `/confirm` (contact.confirm) | 入力内容の確認画面。戻る場合は GET `/confirm/back` (contact.back) | 不要 |
| サンクス | GET `/thanks` (contact.thanks) | 送信完了画面 | 不要 |
| ログイン | `/login` | 管理画面ログイン（Fortify） | 不要 |
| 新規登録 | `/register` | 管理者アカウント登録（Fortify） | 不要 |
| 管理画面トップ | GET `/admin` (admin.dashboard) | お問い合わせ一覧・検索・削除・詳細モーダル | 要ログイン |
| CSVエクスポート | GET `/admin/export` (admin.contacts.export) | 検索条件に応じたCSVダウンロード | 要ログイン |

## テーブル一覧

このアプリで利用するテーブル（users およびアプリ固有テーブル）の構成です。

### users（管理者・ログインユーザー）

| カラム名 | 型 | 説明 |
|----------|-----|------|
| id | bigint unsigned | 主キー |
| name | string | 名前 |
| email | string | メールアドレス（ユニーク） |
| email_verified_at | timestamp nullable | メール認証日時 |
| password | string | パスワード（ハッシュ） |
| remember_token | string nullable | ログイン保持用 |
| created_at | timestamp | 作成日時 |
| updated_at | timestamp | 更新日時 |

### categories（お問い合わせの種類）

| カラム名 | 型 | 説明 |
|----------|-----|------|
| id | bigint unsigned | 主キー |
| content | string(255) | 種類の内容（例: 商品のお届けについて） |
| created_at | timestamp | 作成日時 |
| updated_at | timestamp | 更新日時 |

### contacts（お問い合わせ）

| カラム名 | 型 | 説明 |
|----------|-----|------|
| id | bigint unsigned | 主キー |
| first_name | string | 姓 |
| last_name | string | 名 |
| gender | tinyint unsigned | 性別（1:男性, 2:女性, 3:その他） |
| email | string | メールアドレス |
| tel | string | 電話番号 |
| address | string | 住所 |
| building | string nullable | 建物名・部屋番号 |
| category_id | bigint unsigned | お問い合わせの種類（categories.id への外部キー） |
| detail | string(120) | お問い合わせ内容 |
| created_at | timestamp | 作成日時 |
| updated_at | timestamp | 更新日時 |

## ER 図

<img src="docs/images/ER.svg" width="640" alt="ER図">

ソース（編集用）: [docs/ER.dio]

## URL

-   開発環境：http://localhost/
-   phpMyAdmin:：http://localhost:8080/
