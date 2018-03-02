FROM php:5.6
RUN apt-get update && apt-get install -y zlib1g-dev
RUN docker-php-ext-install mysqli pdo pdo_mysql zip
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
RUN chmod +x wp-cli.phar
RUN mv wp-cli.phar /usr/local/bin/wp

ENV APP_DIR /app
ENV APPLICATION_ENV development

WORKDIR $APP_DIR

RUN echo "memory_limit = 1G\n" > /usr/local/etc/php/conf.d/memory.ini
RUN wp package install aaemnnosttv/wp-cli-dotenv-command --allow-root

EXPOSE 80

CMD (wp dotenv init --template=/app/.env.docker.example --with-salts --allow-root || true) && php -S 0.0.0.0:80 -t /app/web/
