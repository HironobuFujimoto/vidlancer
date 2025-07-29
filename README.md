# VidLancer

<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

VidLancerは、動画配信プラットフォームを想定した学習・ポートフォリオ用のLaravelプロジェクトです。  
以下の技術を使用しています：

- Laravel 10
- PHP 8.2
- MySQL
- Redis + Laravel Queue
- HLSベースの動画配信（CloudFront想定）

## セットアップ

```bash
git clone https://github.com/HironobuFujimoto/vidlancer.git
cd vidlancer
composer install
cp .env.example .env
php artisan key:generate
