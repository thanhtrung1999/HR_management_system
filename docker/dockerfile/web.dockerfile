FROM php:7.4-apache
RUN apt-get update && apt-get install -y \
    libmcrypt-dev \
    openssl \
    libcurl4-openssl-dev \
    libpng-dev \
    zip \
    unzip \
    wget \
    zlib1g-dev \
    libicu-dev && \
    a2enmod rewrite
RUN docker-php-ext-install \
    bcmath \
    curl \
    gd \
    json \
    mysqli \
    opcache \
    pdo \
    pdo_mysql
RUN apt-get install curl
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin \
    --filename=composer

WORKDIR /var/www/html/hr_management_system
COPY . /var/www/html/hr_management_system

EXPOSE 80
