FROM docker.io/library/php:8.1-fpm-alpine AS base

# Install required programs / libs
RUN apk --update --no-cache add \
    bash \
    rabbitmq-c-dev \
    zlib-dev \
    libxml2-dev \
    libzip-dev \
    libmcrypt-dev \
    icu-dev \
    icu-data-full \
    libjpeg-turbo \
    libpng \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    busybox-suid \
    curl \
    shadow \
  && apk add --no-cache --virtual .build-deps \
    $PHPIZE_DEPS \
    g++ \
  # Install php extensions \
  && docker-php-ext-configure intl \
  && docker-php-ext-configure gd --with-jpeg --with-freetype \
  && docker-php-ext-install \
    zip \
    intl \
    pdo pdo_mysql \
    gd \
  && pecl install redis amqp \
  && docker-php-ext-enable redis amqp gd \
  # Ensure www-data has id 1000
  && usermod -u 1000 www-data \
  && groupmod -g 1000 www-data \
  # Remove bloat
  && apk del .build-deps \
  && rm -rf /tmp/* /usr/local/lib/php/doc/* /var/cache/apk/*

# Install XDebug
RUN apk add --no-cache --virtual .build-deps \
    $PHPIZE_DEPS \
    git \
    g++ \
    linux-headers \
  && pecl install xdebug-3.2.1 \
  && docker-php-ext-enable xdebug \
  # Configure xDebug
  && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
  && echo "xdebug.idekey=PHPSTORM" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
  && echo "xdebug.max_nesting_level=1000" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
  && echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
  && echo "xdebug.discover_client_host=false" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
  && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
  # Install Composer
  && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
  && php composer-setup.php --install-dir=/usr/bin/ --filename=composer \
  && php -r "unlink('composer-setup.php');" \
  && apk del .build-deps \
  && rm -rf /tmp/* /usr/local/lib/php/doc/* /var/cache/apk/*

RUN mkdir -p /var/www/html/
WORKDIR /var/www/html

LABEL org.opencontainers.image.source="https://github.com/flagbit/rookies-evento"
LABEL org.opencontainers.image.vendor="Flagbit GmbH & Co. KG"
LABEL org.opencontainers.image.title="Rookie's Evento"
LABEL org.opencontainers.image.description="A great event management software made by our trainees"
