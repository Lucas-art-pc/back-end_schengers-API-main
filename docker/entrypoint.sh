#!/bin/sh
set -e

echo "Aguardando o banco de dados ficar disponível..."
until nc -z -w1 "$DB_HOST" "$DB_PORT"; do
  echo "Banco ainda não respondeu, tentando de novo em 2s..."
  sleep 2
done
echo "Banco disponível!"

echo "Limpando cache de configuração antigo..."
php artisan config:clear

echo "Rodando migrations..."
php artisan migrate --force

echo "Iniciando o servidor..."
exec "$@"