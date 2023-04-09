FROM php:8.1.6-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libwebp-dev \
    libpq-dev \
    zip \
    unzip \
    cron \
    nano \
    libmagickwand-dev \
    libgmp-dev \
    libzip-dev \
    sendmail

# Install MongoDB
RUN apt-get update && \
    apt-get install -y autoconf pkg-config libssl-dev && \
    pecl install mongodb && docker-php-ext-enable mongodb

#RUN pecl install mongodb-1.10.0RC1 \
#    && docker-php-ext-enable mongodb
## libssl required for MongoDB
#RUN apt-get update && apt-get install -y libssl-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# sendmail
RUN echo "sendmail_path=/usr/sbin/sendmail -bs -i" >> /usr/local/etc/php/conf.d/sendmail.ini

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp && \
    docker-php-ext-install pdo pdo_pgsql pdo_mysql mbstring exif pcntl bcmath gd sockets gmp zip

# install pecl extension
RUN pecl install redis-5.3.7 imagick && \
	docker-php-ext-enable redis imagick

# Install the xdebug extension
RUN pecl install xdebug && \
	docker-php-ext-enable xdebug
COPY xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

ADD php.ini /usr/local/etc/php/php.ini

# Set working directory
WORKDIR /var/www

USER $user

# Set aliases
RUN echo 'alias a="php artisan"' >> ~/.bashrc
