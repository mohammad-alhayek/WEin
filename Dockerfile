FROM php:8.2-apache

# تثبيت الحزم الأساسية وأدوات الـ ZIP و Git و libxml وغيرها
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    libxml2-dev

# تثبيت امتدادات PHP الضرورية للارافيل
RUN docker-php-ext-install pdo_mysql gd zip xml

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

# تشغيل Composer لتثبيت الحزم مع تجاهل توافقية الـ PHP إن وجدت مشاكل في الإصدارات
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# ضبط الصلاحيات
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
