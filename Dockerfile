FROM php:8.1.1-fpm

# Copy composer.lock and composer.json
COPY composer.lock composer.json /var/www/

# Set working directory
WORKDIR /var/www

# Add docker php ext repo
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

USER root

# Install php extensions
RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions mbstring exif

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN apt-get update --fix-missing

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libfreetype6-dev \
    libjpeg-dev \
    libjpeg62-turbo-dev \
    locales \
    zip \
    nano \
    unzip \
    git \
    curl \
    nodejs \
    npm

# Install extensions
RUN docker-php-ext-configure gd --with-jpeg --with-freetype --enable-gd
RUN docker-php-ext-install pdo_mysql pcntl
RUN docker-php-ext-install -j$(nproc) gd
# RUN pecl install mongodb

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#RUN pecl install redis \
#&& docker-php-ext-enable redis

# Add user for laravel application
#RUN groupadd -g 1777 www
#RUN useradd -u 1777 -ms /bin/bash -g www www



# Copy existing application directory contents
COPY . /var/www

# Copy existing application directory permissions
COPY --chown=www:www . /var/www

# Change current user to www
USER www

# Expose port 9000 and start php-fpm server
EXPOSE 9000
EXPOSE 6001

CMD ["php-fpm"]
