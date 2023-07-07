FROM php:8

RUN apt-get update && apt-get install -y git unzip

# https://github.com/mlocati/docker-php-extension-installer#supported-php-extensions

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
  install-php-extensions gd bz2 exif imagick

EXPOSE 9000
CMD ["php-fpm"]