#!/bin/bash
set -e

echo "[Laravel Docker] Inisialisasi container Laravel..."

# Pastikan direktori storage dan cache ada dan writable
mkdir -p /var/www/html/bootstrap/cache \
         /var/www/html/storage/framework/cache/data \
         /var/www/html/storage/framework/sessions \
         /var/www/html/storage/framework/views \
         /var/www/html/storage/logs \
         /var/www/html/storage/app/public
chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache || true
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache || true

# Pastikan file .env ada
if [ ! -f /var/www/html/.env ]; then
    echo "[Laravel Docker] Menyalin .env.example ke .env..."
    cp /var/www/html/.env.example /var/www/html/.env
fi

# Jalankan composer dump-autoload atau install jika autoload.php belum ada
if [ ! -f /var/www/html/vendor/autoload.php ]; then
    echo "[Laravel Docker] Menjalankan composer dump-autoload..."
    composer dump-autoload --optimize || composer install --no-interaction --prefer-dist --optimize-autoloader --no-security-blocking
fi

# Generate App Key jika belum diset
if ! grep -q "APP_KEY=base64:" /var/www/html/.env; then
    echo "[Laravel Docker] Membuat APP_KEY..."
    php artisan key:generate --force
fi

# Tunggu database MySQL / MariaDB siap menggunakan PHP PDO
echo "[Laravel Docker] Menunggu koneksi database di ${DB_HOST:-mysql}:${DB_PORT:-3306}..."
until php -r "try { new PDO('mysql:host=' . (getenv('DB_HOST') ?: 'mysql') . ';port=' . (getenv('DB_PORT') ?: '3306') . ';dbname=' . (getenv('DB_DATABASE') ?: 'am_hris'), getenv('DB_USERNAME') ?: 'laravel_user', getenv('DB_PASSWORD') ?: 'password123'); exit(0); } catch (Exception \$e) { exit(1); }"; do
    echo "[Laravel Docker] Database belum siap, mencoba lagi dalam 3 detik..."
    sleep 3
done
echo "[Laravel Docker] Database berhasil terhubung!"

# Jalankan migrasi dan seeder database
echo "[Laravel Docker] Menjalankan migrasi dan seeder database..."
php artisan migrate --force
php artisan db:seed --force

# Pastikan kembali hak akses folder storage dan cache
chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache || true
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache || true

echo "[Laravel Docker] Aplikasi siap dijalankan di http://localhost:8000"

exec "$@"
