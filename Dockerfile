FROM php:8.4-cli

ARG HOST_UID=1000
ARG HOST_GID=1000

RUN apt-get update \
    && apt-get install -y \
        libpq-dev \
        unzip \
    && docker-php-ext-install pdo_pgsql \
    && groupadd -g ${HOST_GID} app \
    && useradd -u ${HOST_UID} -g ${HOST_GID} -m -s /bin/bash app

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install

USER app

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]


