FROM php:8.1-cli

COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY --from=ghcr.io/mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN install-php-extensions zip

WORKDIR /app