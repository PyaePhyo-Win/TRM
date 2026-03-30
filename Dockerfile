# Use a standard PHP image
FROM php:8.2-fpm

# Install system dependencies AND Node.js (for Vite/npm)
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libpq-dev \
    zip \
    unzip \
    git \
    curl \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-install pdo_pgsql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

# 1. Run Composer (PHP dependencies)
RUN composer install --no-dev --optimize-autoloader

# 2. Run Node (Frontend asset building)
RUN npm install
RUN npm run build

# Set permissions for Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose the port Render expects
EXPOSE 10000

# 3. The Start Command: Run migrations, then start the server
CMD sh -c "php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=10000"
