FROM php:8.0-apache
WORKDIR /var/www/html 
RUN apt-get update -y && apt-get install -y libmariadb-dev
RUN docker-php-ext-install pdo_mysql
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libwebp-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    pngquant
RUN docker-php-ext-install gd 
 
