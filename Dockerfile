# Base image with PHP 8
FROM php:8-cli

# Install system dependencies
RUN apt-get update && \
    apt-get install -y \
        libzip-dev \
        zip \
        unzip \
        git

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/html

# Change ownership of Laravel project files
RUN chown -R www-data:www-data /var/www/html

# Copy source code
COPY . .

# Set file permissions
RUN chmod -R 755 storage bootstrap

# Copy example .env file
COPY .env.example .env

# Generate application key
RUN php artisan key:generate

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Set file permissions again after dependencies installation
RUN chmod -R 755 storage bootstrap

# Expose port 8000
EXPOSE 8000

# Start PHP built-in web server
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
