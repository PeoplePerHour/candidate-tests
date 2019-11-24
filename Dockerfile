FROM php:7.3-fpm-alpine

RUN apk add --update

RUN curl -sS https://getcomposer.org/installer | php -- \
  --install-dir=/usr/bin --filename=composer

COPY . /app

RUN cd "/app" && cp .env.example .env && composer install

WORKDIR /app

EXPOSE 8000

CMD php -S 0.0.0.0:8000 -t public
