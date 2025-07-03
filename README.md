# Laravel 家計簿アプリ
Laravelの学習用に作成した家計簿アプリです。  
CRUD機能を実装しています。

## 使用技術
- Laravel 11
- MySQL
- Bladeテンプレート

## セットアップ
```bash
git clone https://github.com/username/laravel-kakeibo.git
cd laravel-kakeibo
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate
php artisan serve
