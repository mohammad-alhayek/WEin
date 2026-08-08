FROM php:8.4-apache-bookworm

# Install system dependencies

RUN apt-get update && apt-get install -y 
git 
curl 
unzip 
zip 
gnupg 
unixodbc-dev 
apt-transport-https 
ca-certificates 
libzip-dev 
libpng-dev 
libjpeg62-turbo-dev 
libfreetype6-dev 
libxml2-dev 
&& rm -rf /var/lib/apt/lists/*

# Install Microsoft SQL Server ODBC Driver 18

RUN mkdir -p /etc/apt/keyrings 
&& curl -fsSL https://packages.microsoft.com/keys/microsoft.asc 
| gpg --dearmor -o /etc/apt/keyrings/microsoft.gpg 
&& echo "deb [arch=amd64 signed-by=/etc/apt/keyrings/microsoft.gpg] https://packages.microsoft.com/debian/12/prod bookworm main" 
> /etc/apt/sources.list.d/mssql-release.list 
&& apt-get update 
&& ACCEPT_EULA=Y apt-get install -y msodbcsql18 
&& rm -rf /var/lib/apt/lists/*

# Install PHP extensions

RUN docker-php-ext-configure gd 
--with-freetype 
--with-jpeg 
&& docker-php-ext-install 
pdo 
pdo_mysql 
zip 
gd 
xml

# Install SQL Server PHP extensions

RUN pecl install sqlsrv pdo_sqlsrv 
&& docker-php-ext-enable sqlsrv pdo_sqlsrv

# Install Composer

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Enable Apache rewrite

RUN a2enmod rewrite

WORKDIR /var/www/html

# Copy Laravel project

COPY . .

# Install Laravel dependencies

RUN composer install 
--no-dev 
--optimize-autoloader 
--no-interaction 
--no-progress

# Create Laravel directories

RUN mkdir -p 
storage/framework/cache 
storage/framework/sessions 
storage/framework/views 
bootstrap/cache

# Permissions

RUN chown -R www-data:www-data storage bootstrap/cache 
&& chmod -R 775 storage bootstrap/cache

# Configure Apache document root

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri 
-e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' 
/etc/apache2/sites-available/*.conf 
/etc/apache2/apache2.conf

# Apache configuration

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Render uses the PORT environment variable.

# Default to 80 if PORT is not provided.

RUN printf '%s\n' 
'Listen 80' 
> /etc/apache2/ports.conf

# Do NOT run:

# php artisan optimize:clear

# php artisan cache:clear

# php artisan config:clear

# php artisan view:clear

#

# These can attempt to connect to SQL Server during Docker build.

# Create startup script

RUN printf '%s\n' 
'#!/bin/sh' 
'set -e' 
'' 
'PORT="${PORT:-80}"' 
'' 
'sed -i "s/^Listen .*/Listen ${PORT}/" /etc/apache2/ports.conf' 
'sed -i "s/<VirtualHost [^>]*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf' 
'' 
'echo "Starting Apache on port ${PORT}"' 
'apache2ctl configtest' 
'exec apache2-foreground' 
> /usr/local/bin/start-render.sh 
&& chmod +x /usr/local/bin/start-render.sh

EXPOSE 80

CMD ["/usr/local/bin/start-render.sh"]
