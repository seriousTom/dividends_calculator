FROM php:8.1-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libgd-dev \
    jpegoptim optipng pngquant gifsicle \
    libonig-dev \
    libzip-dev \
    libxml2-dev \
    zip \
    sudo \
    unzip \
    nano \
    npm \
    libfreetype6-dev libjpeg62-turbo-dev libpng-dev \
    libxml2-dev \
    nodejs

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# xdebug
RUN pecl install xdebug-3.1.5
RUN docker-php-ext-enable xdebug
EXPOSE 9003

# redis
RUN pecl install -o -f redis \
&&  rm -rf /tmp/pear \
&&  docker-php-ext-enable redis

# Install PHP extensions
RUN set -eux; \
    # Install the PHP gd library
    docker-php-ext-configure gd \
#    --prefix=/usr \
    --with-jpeg \
    --with-xpm \
    --with-freetype; \
    docker-php-ext-install gd; \
    php -r 'var_dump(gd_info());'

RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install bcmath
RUN docker-php-ext-install exif

RUN docker-php-ext-install pcntl
RUN apt-get install -y libxml2-dev
RUN docker-php-ext-install soap

RUN apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev
RUN docker-php-ext-configure gd
RUN docker-php-ext-install gd \
            --prefix=/usr \
            --with-jpeg \
            --with-xpm \
            --with-freetype; \
    docker-php-ext-install gd pdo_mysql soap mbstring exif pcntl bcmath zip;

RUN apt-get update && apt-get install -y libmagickwand-dev --no-install-recommends && rm -rf /var/lib/apt/lists/*

RUN mkdir -p /usr/src/php/ext/imagick; \
    curl -fsSL https://github.com/Imagick/imagick/archive/06116aa24b76edaf6b1693198f79e6c295eda8a9.tar.gz | tar xvz -C "/usr/src/php/ext/imagick" --strip 1; \
    docker-php-ext-install imagick;

# Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Node, NPM, Yarn
RUN curl -fsSL https://deb.nodesource.com/setup_lts.x | bash - && apt install -y nodejs && npm -g install yarn --unsafe-perm



# timezone
ENV TZ=Europe/Vilnius
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# cron & supervisor
RUN apt-get install -y cron supervisor

# copy files
COPY etc /etc
COPY usr /usr

RUN mkdir /var/log/cron
RUN touch /var/log/cron/cron.log
RUN chown -R www-data:www-data /var/log/cron
RUN /usr/bin/crontab -u www-data /etc/cron.d/crontab

CMD /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf

EXPOSE 9000

CMD ["php-fpm"]
