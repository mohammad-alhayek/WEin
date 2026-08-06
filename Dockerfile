 FROM php:8.4-apache-bookworm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    zip \
    gnupg \
    unixodbc-dev \
    apt-transport-https \
    ca-certificates \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libxml2-dev


# Microsoft SQL Server ODBC Driver 18
RUN mkdir -p /etc/apt/keyrings \
    && curl -fsSL https://packages.microsoft.com/keys/microsoft.asc \
    | gpg --dearmor -o /etc/apt/keyrings/microsoft.gpg \
    && echo "deb [arch=amd64 signed-by=/etc/apt/keyrings/microsoft.gpg] https://packages.microsoft.com/debian/12/prod bookworm main" \
    > /etc/apt/sources.list.d/mssql-release.list \
    && apt-get update \
    && ACCEPT_EULA=Y apt-get install -y msodbcsql18


RUN docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
    && docker-php-ext-install \
        pdo_mysql \
        zip \
        gd \
        xml


RUN pecl install sqlsrv pdo_sqlsrv \
    && docker-php-ext-enable sqlsrv pdo_sqlsrv


COPY --from=composer:2 /usr/bin/composer /usr/bin/composer


RUN a2enmod rewrite


ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri \
    -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf


WORKDIR /var/www/html

COPY . .


RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction


RUN php artisan config:clear \
    && php artisan cache:clear \
    && php artisan view:clear


RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache


EXPOSE 80

CMD ["apache2-foreground"]
