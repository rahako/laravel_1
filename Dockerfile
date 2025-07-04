FROM php:8.2-fpm

# 必要な拡張のインストール
RUN apt-get update && apt-get install -y \
    git unzip zip curl libzip-dev libonig-dev libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite mbstring zip

# Composerを追加
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# アプリ作業ディレクトリ
WORKDIR /var/www

# アプリコードをコピー
COPY . .

# SQLite DBファイルの作成と環境設定
RUN cp .env.example .env \
    && touch /tmp/sqlite.db \
    && php artisan config:clear \
    && php artisan key:generate

# Composer依存をインストール
RUN composer install --no-dev --optimize-autoloader

# ポートを開ける
EXPOSE 10000

# サーバー起動コマンド
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
