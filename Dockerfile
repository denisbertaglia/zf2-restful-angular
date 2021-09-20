FROM php:7.0-apache

RUN apt-get update \
 && apt-get install -y git curl zlib1g-dev \
 && docker-php-ext-install zip \
 && a2enmod rewrite \
 && sed -i 's!/var/www/html!/var/www/public!g' /etc/apache2/sites-available/000-default.conf

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --version=1.0.0-beta2
RUN chmod +x composer.phar && cp composer.phar /usr/bin/composer

RUN mv /var/www/html /var/www/public

WORKDIR /var/www
