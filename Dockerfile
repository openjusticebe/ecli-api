FROM alpine:3.12

RUN apk --no-cache add \
php7 \
php7-fpm \
php7-pdo \
php7-mbstring \
php7-xml \
php7-openssl \
php7-json \
php7-phar \
php7-zip \
php7-dom \
php7-session \
php7-zlib && \
php7 -r "copy('http://getcomposer.org/installer', 'composer-setup.php');" && \
php7 composer-setup.php --install-dir=/usr/bin --filename=composer && \
php7 -r "unlink('composer-setup.php');" && \
ln -sf /usr/bin/php7 /usr/bin/php && \
ln -s /etc/php7/php.ini /etc/php7/conf.d/php.ini

# RUN set -x \
# addgroup -g 82 -S www-data \
# adduser -u 82 -D -S -G www-data www-data

COPY . /src
ADD .env.example /src/.env
WORKDIR /src
RUN chmod -R 777 storage
CMD php artisan migrate:fresh --seed
CMD php -S 0.0.0.0:8000 -t public
