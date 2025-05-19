FROM php:8.2-fpm-alpine

# Cài đặt các dependencies cần thiết cho imagick
RUN apk add --no-cache --update libxml2-dev libjpeg-turbo-dev libpng-dev freetype-dev

# Cài đặt các công cụ build cần thiết (bao gồm gcc và build-base)
RUN apk add --no-cache --update autoconf automake libtool make gcc build-base

# Cài đặt imagick bằng PECL
RUN pecl install imagick
RUN docker-php-ext-enable imagick

# Cài đặt các extension PHP cần thiết
RUN docker-php-ext-install pdo pdo_mysql bcmath gd zip

# Cài đặt Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Cài đặt Node.js và npm (nếu bạn cần biên dịch assets)
RUN apk add --no-cache nodejs npm

# Thiết lập thư mục làm việc trong container
WORKDIR /var/www/html

# Sao chép mã nguồn Laravel vào container
COPY ../ .

# Cài đặt các dependencies của Laravel
RUN composer install --no-dev --optimize-autoloader

# Tạo bản sao của file .env
COPY .env.example .env

# Tạo key ứng dụng Laravel
RUN php artisan key:generate

# Chạy các migrations (nếu cần)
# RUN php artisan migrate --force

# Thay đổi quyền sở hữu thư mục storage và bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache

# Expose cổng 9000 cho FPM
EXPOSE 9000

# Lệnh chạy ứng dụng (chúng ta sẽ sử dụng Apache để phục vụ ứng dụng này)
# CMD ["php-fpm"]