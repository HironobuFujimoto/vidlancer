# VidLancer

<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

VidLancerは、動画アップロード・配信機能を備えたWebアプリケーションです。  
PHP（Laravel）とffmpegを用いて、ユーザー認証・動画管理・HLS変換・API連携を実装しています。

---

## 主な機能

- JWT認証によるユーザー登録・ログイン
- 動画ファイルのアップロード（ユーザーごとに管理）
- ffmpegによる動画のHLS変換（ジョブキュー利用）
- 動画一覧・詳細・ストリーミングAPI
- RESTfulなAPI設計

---

## 技術スタック

- PHP 8.x / Laravel 10.x
- MySQL（Eloquent ORM）
- ffmpeg（動画変換）
- JWT（認証）
- Laravel Queue（ジョブ管理）
- GitHub（バージョン管理）

---

## セットアップ手順

1. リポジトリをクローン
2. `.env` を作成し、DB・JWT_SECRET・QUEUE設定
3. `composer install`
4. `php artisan migrate`
5. ffmpegをインストール
6. サーバー起動：`php artisan serve`
7. ジョブワーカー起動：`php artisan queue:work`

---

## APIエンドポイント例

- `POST /api/register` ユーザー登録
- `POST /api/login` ログイン（JWT取得）
- `POST /api/videos/upload` 動画アップロード
- `GET /api/videos` 動画一覧
- `GET /api/videos/{id}` 動画詳細
- `GET /api/videos/{id}/stream` HLSストリーム

---

## 工夫・アピールポイント

- JWTによるセキュアな認証
- ジョブキューによる非同期動画変換
- RESTfulなAPI設計
- Eloquent ORMによる効率的なDB操作
- ffmpeg連携による映像配信基盤の構築

---
