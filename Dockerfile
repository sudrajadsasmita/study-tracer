FROM php:8.1-cli

RUN apt-get update -y && apt-get install -y libmcrypt-dev git openssl zip unzip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pdo

WORKDIR /app
COPY . /app

RUN composer install && \
    touch .env && \
    echo "APP_KEY=$APP_KEY" >> .env && \
    php artisan key:generate && \
    php artisan cache:clear && \
    php artisan config:clear && \
    php artisan storage:link

RUN chmod -R 777 storage/ && \
    chmod -R 777 bootstrap/
    

CMD [ "php", "artisan", "serve", "--host=0.0.0.0", "--port=80" ]

EXPOSE 80
