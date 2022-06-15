# image à utiliser
FROM php:8.1.7-fpm-bullseye

# On envoie le nom du serveur à apache, c'est avec ça que l'on appelera nos pages
# RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Quelques library necessaires
RUN apt-get update \
    && apt-get install -y --no-install-recommends locales apt-utils git libicu-dev g++ libpng-dev libzip-dev libjpeg-dev libftgl-dev chromium chromium-driver zip unzip;

RUN docker-php-ext-install gd

COPY --from=composer:2.2.14 /usr/bin/composer /usr/bin/composer

# les locales, toujours utiles
RUN echo "en_US.UTF-8 UTF-8" > /etc/locale.gen && \
    echo "fr_FR.UTF-8 UTF-8" >> /etc/locale.gen && \
    locale-gen

# RUN a2enmod rewrite

ENV PANTHER_CHROME_DRIVER_BINARY /usr/bin/chromedriver
ENV PANTHER_NO_SANDBOX 1
ENV PANTHER_WEB_SERVER_PORT 9800
ENV CUSTOM_PANTHER_BASE_URL http://127.0.0.1:9800
# On copie le php.ini du repertoire actuel dans le contenaire
# COPY php.ini /usr/local/etc/php/php.ini

EXPOSE 9800

# Quelques extesnions de php utiles
RUN docker-php-ext-configure intl
RUN docker-php-ext-configure gd --with-jpeg=/usr/include/ --with-freetype=/usr/include/
RUN docker-php-ext-install pdo pdo_mysql gd opcache intl zip calendar
# RUN pecl install apcu-5.1.5 && docker-php-ext-enable apcu

# le repertoire qui contient vos sources (attention : dans le contenaire, donc le repertoire à droite du mapping du docker-compose)
WORKDIR /var/www/
