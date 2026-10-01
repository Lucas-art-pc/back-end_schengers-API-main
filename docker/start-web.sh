#!/bin/sh
set -e

echo "[web] Aguardando o banco..."
until nc -z -w1 "$DB_HOST" "$DB_PORT"; do
  sleep 2
done

php artisan config:clear
php artisan migrate --force
php artisan storage:link || true

echo "[web] Iniciando Nginx + PHP-FPM..."
exec supervisord -c /etc/supervisor/supervisord.conf