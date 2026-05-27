#!/usr/bin/env sh
set -e

if [ ! -f .env ]; then
    cp .env.example .env
fi

if [ -z "$APP_KEY" ] && ! grep -q '^APP_KEY=base64:' .env; then
    php artisan key:generate --force
fi

php artisan config:clear
php artisan migrate --force || echo "Migration failed; starting app so logs are visible."
php artisan db:seed --force || echo "Seeding failed; starting app so logs are visible."

php artisan serve --host=0.0.0.0 --port="${PORT:-10000}"
