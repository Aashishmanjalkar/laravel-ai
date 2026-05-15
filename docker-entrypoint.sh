#!/bin/sh
set -e

cd /var/www

echo "Bootstrapping Laravel..."

export COMPOSER_PROCESS_TIMEOUT=0

# -----------------------------------
# 1. Install Laravel if missing
# -----------------------------------
if [ ! -f artisan ]; then
    echo "Laravel not found. Installing..."

    rm -rf temp

    composer create-project laravel/laravel temp --no-interaction --prefer-dist --no-progress

    echo "Moving Laravel files..."

    mv temp/* .
    mv temp/.[!.]* . 2>/dev/null || true

    rm -rf temp
fi

# -----------------------------------
# 2. Ensure correct .env (IMPORTANT)
# -----------------------------------
echo "Applying Docker environment configuration..."
cp .env.docker .env

# -----------------------------------
# 3. Install dependencies
# -----------------------------------
if [ ! -d vendor ]; then
    echo "Installing dependencies..."
    composer install --no-interaction --prefer-dist --no-progress --optimize-autoloader
fi

# -----------------------------------
# 4. Fix permissions
# -----------------------------------
echo "Fixing permissions..."
chown -R www-data:www-data storage bootstrap/cache || true
chmod -R 775 storage bootstrap/cache || true

# -----------------------------------
# 5. Generate app key
# -----------------------------------
if ! grep -q "^APP_KEY=base64" .env; then
    echo "Generating app key..."
    php artisan key:generate --force
fi

# -----------------------------------
# 6. Wait for PostgreSQL
# -----------------------------------
echo "Waiting for PostgreSQL..."

until php -r "
try {
    new PDO('pgsql:host=postgres;port=5432;dbname=laravel_db', 'user', 'user123');
    echo 'DB connected\n';
} catch (Exception \$e) {
    exit(1);
}
"; do
    sleep 2
done

# -----------------------------------
# 7. Run migrations (background)
# -----------------------------------
(
    echo "Running migrations..."
    php artisan migrate --force || true

    echo "Clearing config cache..."
    php artisan config:clear || true
) &

# -----------------------------------
# 8. Start PHP-FPM
# -----------------------------------
echo "Starting PHP-FPM..."
exec php-fpm -F
