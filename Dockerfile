FROM php:8.2-fpm

# 必要なPHP拡張とツールをインストール
RUN apt-get update && apt-get install -y \
    git unzip zip curl libzip-dev libonig-dev libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite mbstring zip

# Composer追加
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 作業ディレクトリ
WORKDIR /var/www

# アプリコードをコピー
COPY . .

# .envとSQLiteファイルの準備
RUN cp .env.example .env \
    && touch /var/www/sqlite.db \
    && composer install --no-dev --optimize-autoloader

# 初期化とサーバ起動
CMD php artisan config:clear \
 && php artisan key:generate \
 && php artisan migrate --force \
 && php artisan serve --host=0.0.0.0 --port=10000

EXPOSE 10000
