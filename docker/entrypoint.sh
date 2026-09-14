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

if [ "$PROCESS_TYPE" = "queue" ]; then
  echo "Iniciando worker de fila (via supervisor)..."
  exec supervisord -c /etc/supervisor/supervisord-queue.conf
else
  echo "Rodando migrations..."
  php artisan migrate --force

  echo "Criando link de storage..."
  php artisan storage:link || echo "Link já existe, seguindo..."

  echo "Iniciando Nginx + PHP-FPM..."
  exec supervisord -c /etc/supervisor/supervisord.conf
fi