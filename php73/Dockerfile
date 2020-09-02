# image à utiliser
FROM php:7.3-apache

ARG USER_ID=1000
ARG GROUP_ID=1000
ARG USER_NAME=damien

# On envoie le nom du serveur à apache, c'est avec ça que l'on appelera nos pages
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Quelques library necessaires
RUN apt-get update \
    && apt-get install -y --no-install-recommends locales apt-utils git libicu-dev g++ libpng-dev libzip-dev;

# les locales, toujours utiles
RUN echo "en_US.UTF-8 UTF-8" > /etc/locale.gen && \
    echo "fr_FR.UTF-8 UTF-8" >> /etc/locale.gen && \
    locale-gen

RUN a2enmod rewrite

# On copie le php.ini du repertoire actuel dans le contenaire
# COPY php.ini /usr/local/etc/php/php.ini

# on télécharge et deplace le composer
# RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tls && \
#    mv composer.phar /usr/local/bin/composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Quelques extesnions de php utiles
RUN docker-php-ext-configure intl
RUN docker-php-ext-install pdo pdo_mysql gd opcache intl zip calendar
# RUN pecl install apcu-5.1.5 && docker-php-ext-enable apcu

# On créé un utilisateur avec le même gid/uid que votre local
# cela va permettre que les fichiers qui sont créés dans le contenaire auront vos droits
RUN addgroup --gid $GROUP_ID $USER_NAME
RUN adduser --disabled-password --gecos '' --uid $USER_ID --gid $GROUP_ID $USER_NAME
# USER user
# le repertoire qui contient vos sources (attention : dans le contenaire, donc le repertoire à droite du mapping du docker-compose)
WORKDIR /var/www/