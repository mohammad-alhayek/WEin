FROM php:8.2-apache

# تثبيت الحزم المطلوبة للارافيل
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    git \
    curl

RUN docker-php-ext-install pdo_mysql gd

# تفعيل مود الـ Apache Rewrite
RUN a2enmod rewrite

# تغيير مسار الـ Apache DocumentRoot لمجلد public الخاص بلارافيل
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
EXPOSE 80
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# نسخ ملفات المشروع
COPY . /var/www/html

# ضبط الصلاحيات
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

WORKDIR /var/www/html