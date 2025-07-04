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

# SQLite対応：.env作成＆DBファイル作成
RUN cp .env.example .env \
    && touch /tmp/sqlite.db

# Laravelの依存インストール
RUN composer install --no-dev --optimize-autoloader

# Laravel初期化は起動時に（APP_KEYなければ生成）
CMD ["/bin/sh", "-c", "if [ ! -f /var/www/storage/oauth-private.key ]; then php artisan key:generate; fi && php artisan serve --host=0.0.0.0 --port=10000"]

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
EXPOSE 10000
