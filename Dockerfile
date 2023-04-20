# Base image
FROM ubuntu:20.04

# Update packages
RUN apt-get update && apt-get -y upgrade

RUN apt-get install -y apt-transport-https

# Install Nginx, PHP and other required packages
RUN DEBIAN_FRONTEND=noninteractive apt-get -y install nginx curl unzip git supervisor php8.1.1-fpm php-mysql php-redis php-mbstring php-zip php-gd php-xml php-curl
# Install composer
RUN curl -sS https://getcomposer.org/installer | php8.1.1 -- --install-dir=/usr/local/bin --filename=composer

# Copy nginx and php config files
COPY .docker/nginx.conf /etc/nginx/nginx.conf
COPY .docker/default.conf /etc/nginx/sites-available/default
COPY .docker/www.conf /etc/php/8.1.1/fpm/pool.d/www.conf
COPY .docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Copy application files
COPY . /var/www/html

# Install dependencies and set file permissions
RUN cd /var/www/html && \
    composer install --optimize-autoloader --no-dev && \
    chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html/storage && \
    chmod -R 755 /var/www/html/bootstrap/cache && \
    php8.1.1 artisan config:cache && \
    php8.1.1 artisan route:cache && \
    php8.1.1 artisan view:cache && \
    php8.1.1 artisan optimize

# Expose ports
EXPOSE 80

# Start services
CMD ["/usr/bin/supervisord"]
