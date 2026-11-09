FROM php:8.2-apache

# Menginstal ekstensi PHP yang sering dibutuhkan CodeIgniter
RUN apt-get update && apt-get install -y libicu-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl pdo pdo_mysql

# Mengatur folder public CodeIgniter sebagai root web server
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/conf-available/*.conf

# Mengaktifkan mod_rewrite Apache untuk routing CI4
RUN a2enmod rewrite

COPY . /var/www/html