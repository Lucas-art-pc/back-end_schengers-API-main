#!/bin/sh
set -e

echo "[worker] Aguardando o banco..."
until nc -z -w1 "$DB_HOST" "$DB_PORT"; do
  sleep 2
done

php artisan config:clear

echo "[worker] Iniciando queue:work (conexao: $QUEUE_CONNECTION, mailer: $MAIL_MAILER)..."
exec php artisan queue:work --tries=3 --backoff=5 --sleep=3 --timeout=30 -vvv