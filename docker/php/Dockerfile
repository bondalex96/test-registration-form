FROM php:7.3-fpm

RUN apt-get update && apt-get install -y \
    git \
    openssh-server \
    openssh-client \
    unzip \
    libicu-dev \
    libzip-dev \
    libmagickwand-dev --no-install-recommends

RUN apt-get update && apt-get install -y libmagickwand-6.q16-dev --no-install-recommends \
&& ln -s /usr/lib/x86_64-linux-gnu/ImageMagick-6.8.9/bin-Q16/MagickWand-config /usr/bin \
&& pecl install imagick \
&& echo "extension=imagick.so" > /usr/local/etc/php/conf.d/ext-imagick.ini

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

# Set timezone
RUN rm /etc/localtime
RUN ln -s /usr/share/zoneinfo/Europe/Moscow /etc/localtime
RUN "date"

# Type docker-php-ext-install to see available extensions
RUN docker-php-ext-configure intl
RUN docker-php-ext-install pdo pdo_mysql intl zip
RUN pecl install redis-3.1.3 && docker-php-ext-enable redis


WORKDIR /var/www/app

ENV PATH="~/.composer/vendor/bin:./vendor/bin:${PATH}"
