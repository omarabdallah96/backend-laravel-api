# Use the official PHP image as the base image
FROM php:8.0-apache

# Install necessary extensions and packages
RUN docker-php-ext-install pdo_mysql
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set the working directory
WORKDIR /var/www/html

# Copy the codebase into the container
COPY . /var/www/html

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install project dependencies
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Set file permissions
RUN chown -R www-data:www-data /var/www/html/storage
RUN chmod -R 775 /var/www/html/storage

# Expose port 8000
EXPOSE 8000

CMD php artisan serve --host=0.0.0.0 --port=8000 
