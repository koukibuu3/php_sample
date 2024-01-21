FROM php:8.3.0-apache

RUN docker-php-ext-install pdo_mysql
