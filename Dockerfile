# Base image
FROM php:8.2-fpm

# Dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libpq-dev  # Adicionado para PostgreSQL


# PHP extensions required
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd sockets pdo_pgsql # Adicionado pdo_pgsql para PostgreSQL

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Working directory
WORKDIR /var/www

# Copying project code to container
COPY . .

# Permissions for the working directory
RUN chown -R www-data:www-data /var/www

# Expose the port to the web server
EXPOSE 9000

# Run PHP-FPM (image)
CMD ["php-fpm"]