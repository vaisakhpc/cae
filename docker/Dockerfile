# Use the official PHP image as base
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www/

# Install system dependencies
RUN apt-get update && apt-get install -y \
    sqlite3 \
    libsqlite3-dev \
    git \
    zip \
    && docker-php-ext-install -j$(nproc) pdo_sqlite \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./docker/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# Copy application files
COPY . .

# Set permissions
RUN chown -R www-data:www-data /var/www/storage

# Expose port
EXPOSE 9000

# Run the application
CMD ["php-fpm"]
