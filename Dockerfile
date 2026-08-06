FROM php:8.4-apache

# تثبيت متطلبات النظام
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    zip \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libxml2-dev \
    gnupg2 \
    unixodbc-dev \
    apt-transport-https \
    ca-certificates

# تثبيت Microsoft ODBC Driver 18
RUN curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add - && \
    curl https://packages.microsoft.com/config/debian/12/prod.list > /etc/apt/sources.list.d/mssql-release.list && \
    apt-get update && \
    ACCEPT_EULA=Y apt-get install -y msodbcsql18

# تثبيت امتدادات PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install \
        pdo_mysql \
        zip \
        gd \
        xml

# تثبيت sqlsrv
RUN pecl install sqlsrv pdo_sqlsrv && \
    docker-php-ext-enable sqlsrv pdo_sqlsrv

# تثبيت Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# تفعيل Apache Rewrite
RUN a2enmod rewrite

# جعل public هو DocumentRoot
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri \
    -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf \
    /etc/apache2/conf-available/*.conf

# نسخ المشروع
WORKDIR /var/www/html
COPY . .

# تثبيت الحزم
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction

# صلاحيات Laravel
RUN mkdir -p storage bootstrap/cache && \
    chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache

EXPOSE 80

CMD ["apache2-foreground"]
