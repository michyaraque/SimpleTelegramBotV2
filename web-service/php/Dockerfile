FROM php:8.1.0-fpm

#Script para instalar de forma rápida modulos para PHP
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

COPY php.ini /usr/local/etc/php/conf.d

# 
RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
  install-php-extensions @composer redis gd intl opcache xsl zip bz2 \
  gmp pdo_mysql