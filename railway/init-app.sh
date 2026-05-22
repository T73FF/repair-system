#!/bin/bash
set -e

echo "📦 Установка зависимостей..."
composer install --no-interaction --no-progress --optimize-autoloader

echo "📄 Копирование .env..."
cp .env.example .env || true

echo "🔑 Генерация ключа..."
php artisan key:generate --force

echo "📊 Миграции и сидеры..."
php artisan migrate --force
php artisan db:seed --force

echo "🔗 Ссылка на storage..."
php artisan storage:link

echo "🧹 Кеширование..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Готово!"