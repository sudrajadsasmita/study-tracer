FROM php:8.1-fpm

RUN apt-get update && \
    apt-get install -y \
        libpng-dev \
        libonig-dev \
        libxml2-dev \
        zip \
        unzip \
        git \
        curl \
        libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_port=9000" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "upload_max_filesize=50M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size=50M" >> /usr/local/etc/php/conf.d/uploads.ini

WORKDIR /var/www/html

# Copy source files
WORKDIR /var/www/html
COPY . /var/www/html

# RUN service mysql start && \
#     mysql -e "CREATE DATABASE study-tracer"

# Install dependencies
RUN composer install --no-dev --no-scripts --no-progress --prefer-dist && \
    php artisan cache:clear && \
    php artisan config:clear

# Configure supervisord
COPY ./.docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
RUN mkdir /var/log/mysql

EXPOSE 80

CMD ["/usr/bin/supervisord -c"]
