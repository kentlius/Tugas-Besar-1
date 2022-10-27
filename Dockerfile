FROM php:8.0-apache

RUN apt-get update && apt-get install -y libpq-dev ffmpeg && docker-php-ext-install pdo pdo_pgsql