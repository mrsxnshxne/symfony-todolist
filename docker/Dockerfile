FROM php:8.2-apache

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    cron \
    locales \
    coreutils \
    apt-utils \
    git \
    libicu-dev \
    g++ \
    libpng-dev \
    libxml2-dev \
    libzip-dev \
    libonig-dev \
    libxslt-dev

RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    mysqli \
    gd \
    opcache \
    intl \
    zip \
    calendar \
    dom \
    mbstring \
    xsl \
    && a2enmod rewrite

RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tls && \
   mv composer.phar /usr/local/bin/composer
RUN curl -sS https://get.symfony.com/cli/installer | bash && \
    mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

WORKDIR /var/www/
COPY ./src /var/www/

RUN chown -R www-data:www-data /var/www
RUN chmod -R 755 /var/www

USER www-data
RUN composer install