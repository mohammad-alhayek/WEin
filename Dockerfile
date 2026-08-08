FROM php:8.4-apache-bookworm

RUN apt-get update && apt-get install -y git curl unzip zip gnupg unixodbc-dev apt-transport-https ca-certificates libzip-dev libpng-dev libjpeg62-turbo-dev libfreetype6-dev libxml2-dev && rm -rf /var/lib/apt/lists/*
RUN mkdir -p /etc/apt/keyrings && curl -fsSL https://packages.microsoft.com/keys/microsoft.asc | gpg --dearmor -o /etc/apt/keyrings/microsoft.gpg && echo "deb [arch=amd64 signed-by=/etc/apt/keyrings/microsoft.gpg] https://packages.microsoft.com/debian/12/prod bookworm main" > /etc/apt/sources.list.d/mssql-release.list && apt-get update && ACCEPT_EULA=Y apt-get install -y msodbcsql18 && rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && docker-php-ext-install pdo pdo_mysql zip gd xml
RUN pecl install sqlsrv pdo_sqlsrv && docker-php-ext-enable sqlsrv pdo_sqlsrv

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN a2enmod rewrite

WORKDIR /var/www/html
COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress

RUN mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache && chmod -R 775 storage bootstrap/cache

# VirtualHost ثابت على بورت 80 وقت البناء - رح ينستبدل وقت التشغيل عبر entrypoint
RUN printf '%s\n' \
    '<VirtualHost *:80>' \
    'ServerName localhost' \
    'DocumentRoot /var/www/html/public' \
    '<Directory /var/www/html/public>' \
    'AllowOverride All' \
    'Require all granted' \
    'Options FollowSymLinks' \
    'DirectoryIndex index.php index.html' \
    '</Directory>' \
    'ErrorLog ${APACHE_LOG_DIR}/error.log' \
    'CustomLog ${APACHE_LOG_DIR}/access.log combined' \
    '</VirtualHost>' \
    > /etc/apache2/sites-available/000-default.conf

# إنشاء entrypoint script بيستبدل PORT وقت التشغيل (مش وقت البناء) + سطور تشخيص
RUN printf '%s\n' \
    '#!/bin/bash' \
    'set -e' \
    ': "${PORT:=80}"' \
    'echo "=== Starting with PORT=${PORT} ==="' \
    'sed -i "s/Listen 80/Listen ${PORT}/g" /etc/apache2/ports.conf' \
    'sed -i "s/:80>/:${PORT}>/g" /etc/apache2/sites-available/000-default.conf' \
    'echo "--- ports.conf content ---"' \
    'cat /etc/apache2/ports.conf' \
    'echo "--- 000-default.conf content ---"' \
    'cat /etc/apache2/sites-available/000-default.conf' \
    'echo "=== Launching apache ==="' \
    'exec "$@"' \
    > /usr/local/bin/docker-entrypoint.sh \
    && chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 10000

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["apache2-foreground"]
