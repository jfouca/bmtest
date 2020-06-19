FROM php:7.3-fpm

RUN apt-get update && apt-get install -my git curl wget zip gnupg

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer
RUN chmod +x /usr/local/bin/composer
RUN apt-get update
RUN mkdir -p /var/www/html
ADD . /var/www/html
WORKDIR /var/www/html
RUN chown -R www-data:www-data /var/www/html