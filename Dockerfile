FROM ubuntu:20.04

RUN apt-get update && \
    apt-get install -y software-properties-common && \
    add-apt-repository -y ppa:ondrej/php && \
    apt-get update

# Update and install necessary packages
RUN apt-get update && \
    DEBIAN_FRONTEND=noninteractive apt-get install -y \
    nginx \
    php8.1 \
    php8.1-cli \
    php8.1-common \
    php8.1-curl \
    php8.1-fpm \
    php8.1-gd \
    php8.1-mbstring \
    php8.1-mysql \
    php8.1-pgsql \
    php8.1-xml \
    php8.1-zip \
    composer \
    supervisor \
    curl \
    git \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Set timezone
RUN ln -snf /usr/share/zoneinfo/Asia/Jakarta /etc/localtime && echo Asia/Jakarta > /etc/timezone

# Configure Nginx
COPY ./.docker/nginx/default.conf /etc/nginx/sites-available/default
RUN ln -sf /dev/stdout /var/log/nginx/access.log && ln -sf /dev/stderr /var/log/nginx/error.log

# Copy source files
WORKDIR /var/www/html
COPY . /var/www/html

# RUN service mysql start && \
#     mysql -e "CREATE DATABASE study-tracer"
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install dependencies
RUN composer install --no-dev --no-scripts --no-progress --prefer-dist && \
    php artisan cache:clear && \
    php artisan config:clear

# Configure supervisord
COPY ./.docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
RUN mkdir /var/log/mysql

EXPOSE 80

CMD ["/usr/bin/supervisord"]
