# compile
FROM node:18-alpine AS compile

WORKDIR /app

COPY package.json yarn.lock ./

RUN yarn --non-interactive

COPY . .

RUN yarn run build && rm -rf node_modules

# runtime
FROM php:8.2-alpine AS runtime

RUN apk update && apk add --no-cache linux-headers libmemcached-dev zlib-dev curl autoconf gcc g++ make zip freetype-dev libzip-dev libpng-dev libwebp-dev libjpeg-turbo-dev icu-dev
RUN pecl install -D 'enable-redis-igbinary="yes" enable-redis-lzf="no" enable-redis-zstd="no"' igbinary redis && \
    docker-php-ext-enable igbinary redis && \
    docker-php-ext-configure gd --with-webp --with-freetype=/usr/include/ --with-jpeg=/usr/include/ && \
    docker-php-ext-install -j$(getconf _NPROCESSORS_ONLN) sockets bcmath bz2 exif gd intl pcntl zip pdo_mysql

COPY --from=spiralscout/roadrunner:2023.2 /usr/bin/rr /usr/local/bin/rr
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN cp -f /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini

# app
FROM runtime

WORKDIR /app

COPY --from=compile /app/composer.json /app/composer.lock ./

RUN composer install --no-autoloader --no-scripts --no-dev

COPY --from=compile /app .

RUN ln -sf /usr/local/bin/rr .

RUN composer dump-autoload -o && \
    php artisan admin:publish && \
    php artisan optimize && \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan config:clear && \
    # chmod -R 0775 /app && \
    chmod -R 0777 /app/storage

EXPOSE 8000

HEALTHCHECK CMD ["php", "artisan", "octane:status"]

CMD ["php", "artisan", "octane:start", "--host=0.0.0.0", "-n"]
