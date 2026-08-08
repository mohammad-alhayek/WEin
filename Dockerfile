FROM php:8.4-apache-bookworm

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

RUN mkdir -p /etc/apt/keyrings 
&& curl -fsSL https://packages.microsoft.com/keys/microsoft.asc 
| gpg --dearmor -o /etc/apt/keyrings/microsoft.gpg 
&& echo "deb [arch=amd64 signed-by=/etc/apt/keyrings/microsoft.gpg] https://packages.microsoft.com/debian/12/prod bookworm main" 
> /etc/apt/sources.list.d/mssql-release.list 
&& apt-get update 
&& ACCEPT_EULA=Y apt-get install -y msodbcsql18 
&& rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure gd 
--with-freetype 
--with-jpeg 
&& docker-php-ext-install 
pdo 
pdo_mysql 
zip 
gd 
xml

RUN pecl install sqlsrv pdo_sqlsrv 
&& docker-php-ext-enable sqlsrv pdo_sqlsrv

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN a2enmod rewrite

RUN echo "ServerName localhost" > /etc/apache2/conf-available/servername.conf 
&& a2enconf servername

WORKDIR /var/www/html

COPY . .

RUN composer install 
--no-dev 
--optimize-autoloader 
--no-interaction 
--no-progress

RUN mkdir -p 
storage/framework/cache 
storage/framework/sessions 
storage/framework/views 
bootstrap/cache

RUN chown -R www-data:www-data storage bootstrap/cache 
&& chmod -R 775 storage bootstrap/cache

RUN cat > /etc/apache2/sites-available/000-default.conf <<'EOF'
<VirtualHost *:80>
ServerName localhost

```
DocumentRoot /var/www/html/public

<Directory /var/www/html/public>
    AllowOverride All
    Require all granted
    Options FollowSymLinks
</Directory>

ErrorLog ${APACHE_LOG_DIR}/error.log
CustomLog ${APACHE_LOG_DIR}/access.log combined

DirectoryIndex index.php index.html
```

</VirtualHost>
EOF

RUN sed -i 's/^Listen 80$/Listen 0.0.0.0:80/' /etc/apache2/ports.conf

RUN apache2ctl configtest

EXPOSE 80

CMD ["apache2-foreground"]
