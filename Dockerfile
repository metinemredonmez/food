FROM php:8.3-apache

RUN docker-php-ext-install pdo_mysql

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && a2enmod rewrite headers \
    && printf 'upload_max_filesize=8M\npost_max_size=9M\n' > /usr/local/etc/php/conf.d/uploads.ini
