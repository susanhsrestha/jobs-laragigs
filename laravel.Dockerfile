FROM php:8.2-apache
RUN apt-get update && \ 
    apt-get install -y \
    zip unzip \
    libicu-dev \
    libmariadb-dev \
    unzip zip \
    zlib1g-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \ 
    libpng-dev
RUN curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php
RUN php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install gettext intl pdo_mysql gd
WORKDIR /app
COPY . .
RUN chmod 755 /app
ADD .env.example .env
RUN composer install
RUN php artisan key:generate
EXPOSE 8000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
