FROM php:8.4-fpm AS pet-store-php

# Copy composer.lock and composer.json into the working directory
COPY composer.lock composer.json /var/www/app/

# Set working directory
WORKDIR /var/www/app/

# Install dependencies for the operating system software
RUN apt-get update && \
apt-get -y upgrade && \
apt-get install -y aptitude && \
apt-get install -y --no-install-recommends nginx supervisor && \
apt-get install -y build-essential software-properties-common byobu curl ca-certificates git htop man unzip vim wget libcurl4 libcurl4-gnutls-dev libpcre3 libpcre3-dev libxml2 libxml2-dev liblua5.3-0 liblua5.3-0-dbg liblua5.3-dev \
libxml2-dev libxslt-dev libgd-dev libiconv-hook-dev libicu-dev libonig-dev zlib1g-dev libzip-dev libpq-dev \
libbz2-dev openssl libssl-dev libfreetype6-dev libjpeg62-turbo-dev libpng-dev libmemcached-dev libmemcached11

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions for php
RUN update-ca-certificates && \
docker-php-ext-install bcmath ctype curl dom fileinfo && \
docker-php-ext-configure gd --with-freetype --with-jpeg --with-xpm --enable-gd-jis-conv && \
docker-php-ext-install -j$(nproc) gd && \
docker-php-ext-install iconv && \
docker-php-ext-configure intl && \
docker-php-ext-install intl && \
docker-php-ext-install mbstring xml simplexml xsl soap zip sockets
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd
RUN docker-php-ext-install exif

# install redis support
RUN pecl install redis && docker-php-ext-enable redis

# enable exif
RUN docker-php-ext-configure exif
RUN docker-php-ext-install exif
RUN docker-php-ext-enable exif

# add pgsql support
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql
RUN docker-php-ext-install pdo pdo_pgsql pgsql pdo_mysql

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy existing application directory contents to the working directory
COPY . /var/www/app

# Configure Nginx
RUN rm /etc/nginx/sites-enabled/default
ADD .docker/nginx/app.conf /etc/nginx/sites-available/default
RUN ln -s /etc/nginx/sites-available/default /etc/nginx/sites-enabled/

# Assign permissions of the working directory to the www-data user
RUN chown -R www-data:www-data \
        /var/www -R

RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash -  \
    && apt-get install -y nodejs

EXPOSE 80
COPY .docker/php/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh
CMD ["/usr/local/bin/start.sh"]

