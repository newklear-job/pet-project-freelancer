FROM php:8.1-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid
ARG GITHUB_TOKEN

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nano \
    sqlite3 \
    libpq-dev \
    && apt-get clean -y \
    && docker-php-ext-install soap

RUN pecl install redis && docker-php-ext-enable redis

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath gd calendar

# Get lts nodejs
RUN curl -fsSL https://deb.nodesource.com/setup_lts.x | bash -
RUN apt-get install -y nodejs

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# install xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host = host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Install spatie backup dependencies
RUN apt-get install -y \
        libzip-dev \
        zip \
        mariadb-client \
  && docker-php-ext-install zip

# Install spatie medialibrary dependencies
RUN apt-get install -y \
    jpegoptim \
    optipng \
    pngquant \
    gifsicle \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

RUN npm install -g svgo

# Setup deptrac

RUN curl -LS https://github.com/qossmic/deptrac/releases/download/0.19.3/deptrac.phar -o deptrac.phar \
    && chmod +x deptrac.phar \
    && mv deptrac.phar /usr/local/bin/deptrac \
    && apt-get install -y graphviz

# Set working directory
WORKDIR /var/www/project

USER $user

# github personal access token
RUN git config --global user.email "petergerinv@gmail.com"
RUN git config --global user.name "Vitalii"
RUN git config --global url.https://$GITHUB_TOKEN:@github.com/.insteadOf https://github.com/

