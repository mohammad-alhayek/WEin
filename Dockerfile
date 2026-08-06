FROM php:8.2-apache

# تثبيت متطلبات النظام الأساسية
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    libxml2-dev \
    gnupg2 \
    unixodbc-dev

# تثبيت أدوات مايكروسوفت لـ SQL Server (ODBC Driver 18)
RUN curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add - \
    && curl https://packages.microsoft.com/config/debian/11/prod.list > /etc/apt/sources.list.d/mssql-release.list \
    && apt-get update \
    && ACCEPT_EULA=Y apt-get install -y msodbcsql18

# تثبيت امتدادات PHP لـ MySQL و SQL Server و Zip
RUN docker-php-ext-install pdo_mysql gd zip xml \
    && pecl install sqlsrv pdo_sqlsrv \
    && docker-php-ext-enable sqlsrv pdo_sqlsrv

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# تفعيل مود الـ Apache Rewrite
RUN a2enmod rewrite

# تغيير مسار الـ Apache DocumentRoot لمجلد public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
EXPOSE 80
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# نسخ ملفات المشروع
COPY . /var/www/html

WORKDIR /var/www/html

# تشغيل Composer لتثبيت الحزم
RUN composer update --no-interaction --prefer-dist --optimize-autoloader --ignore-platform-reqs

# ضبط الصلاحيات للمجلدات الحيوية
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
