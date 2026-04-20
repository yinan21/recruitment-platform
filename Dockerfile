FROM php:8.3-cli

# System dependencies
RUN apt-get update && apt-get install -y \
    git curl unzip zip libsqlite3-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_sqlite mbstring

# Install Node.js (for Vite)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Install Composer (FIX)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

# ensure clean install
RUN rm -rf node_modules public/build

RUN composer install --no-interaction --prefer-dist --optimize-autoloader

RUN npm install
RUN npm run build
RUN chown -R www-data:www-data /var/www
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache /var/www/public/build


RUN php artisan config:clear \
 && php artisan cache:clear \
 && php artisan view:clear \
 && php artisan route:clear
# DEBUG: confirm manifest exists during build
RUN ls -la public/build

# Ensure SQLite database file exists
RUN touch database/database.sqlite

# Permissions (important for Laravel)
RUN chown -R www-data:www-data storage bootstrap/cache || true
RUN chmod -R 775 storage bootstrap/cache

# Render exposes dynamic PORT
EXPOSE 10000

# Start Laravel
CMD php artisan config:clear && php artisan view:clear && php artisan migrate --seed --force && php -S 0.0.0.0:10000 -t public