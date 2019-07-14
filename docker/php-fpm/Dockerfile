FROM php:7-fpm
 
ENV DEBIAN_FRONTEND noninteractive
 
RUN apt-get update && apt-get install -y git zlib1g-dev zip unzip libzip-dev
RUN docker-php-ext-install zip mysqli pdo_mysql
 
RUN mkdir -p /app
ADD ./ /app
WORKDIR /app
 
RUN usermod -u 1000 www-data
RUN groupmod -g 1000 www-data
RUN chown -R www-data:www-data /app
 
# install composer
#ENV COMPOSER_ALLOW_SUPERUSER 1
#ENV COMPOSER_HOME /composer
#ENV PATH $PATH:/composer/vendor/bin
#RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

## Errorで追加
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer
RUN composer global require hirak/prestissimo
RUN cp .env.example .env
RUN composer install
RUN php artisan key:generate
RUN chmod -R a+w storage/ bootstrap/cache
