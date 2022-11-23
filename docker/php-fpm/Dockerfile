FROM php:8.0-fpm

RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
RUN cp wp-cli.phar /usr/local/bin/wp
RUN chmod +x /usr/local/bin/wp

RUN apt-get update && \
    apt-get install -y --no-install-recommends libssl-dev zlib1g-dev curl git unzip netcat libxml2-dev libpq-dev libzip-dev && \
    pecl install apcu xdebug   && \
    docker-php-ext-install -j$(nproc) zip opcache intl  mysqli && \
    docker-php-ext-enable apcu  sodium xdebug mysqli  && \
    apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

CMD composer i -o;  php-fpm

EXPOSE 9000 9003
