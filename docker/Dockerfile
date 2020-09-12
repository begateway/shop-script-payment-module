FROM php:7.2-apache

ARG webasyst_version

ADD src/shop-script-${webasyst_version}.tar.gz /var/www/html

RUN mkdir /begateway && \
    chown -R www-data.www-data /var/www/html

RUN apt-get update && apt-get install -y \
    libzip-dev && \
    docker-php-ext-install mysqli && \
    docker-php-ext-install zip

VOLUME ["/var/www/html"]

COPY docker-entrypoint.sh /usr/local/bin/

ENTRYPOINT ["docker-entrypoint.sh"]
