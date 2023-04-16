FROM php:8.1-fpm

# Install necessary packages
RUN apt-get update && \
    apt-get install -y --no-install-recommends \
        unzip \
        zip \
        libpq-dev \
        libicu-dev \
        libzip-dev \
        libonig-dev \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        git \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install \
    bcmath \
    gd \
    intl \
    mysqli \
    pdo \
    pdo_mysql \
    pdo_pgsql \
    pgsql \
    zip \
    opcache

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN chmod 777 -R /var/www/storage/ && \
    chown -R www-data:www-data /var/www/ && \
    a2enmod rewrite


WORKDIR /var/www/html

CMD ["php-fpm"]

EXPOSE 9000
