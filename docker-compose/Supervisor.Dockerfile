FROM php:8.1-fpm

ARG user
ARG uid

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libonig-dev \
        libpq-dev \
        libpng-dev \
        git \
        zip \
        libzip-dev \
        unzip \
        curl \
        supervisor \
        tesseract-ocr \
        tesseract-ocr-rus \
        libmagickwand-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo_pgsql mbstring exif zip

# Imagick
RUN pecl install imagick  \
    && docker-php-ext-enable imagick

COPY docker-compose/php/policy.xml /etc/ImageMagick-6/policy.xml

# SuperVisor
RUN mkdir -p "/etc/supervisor/logs"

COPY docker-compose/supervisor/workers.conf /etc/supervisor/conf.d/workers.conf
COPY docker-compose/supervisor/supervisord.conf /etc/supervisor/supervisord.conf

ENTRYPOINT /usr/bin/supervisord -c /etc/supervisor/supervisord.conf

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

WORKDIR /var/www

USER $user
