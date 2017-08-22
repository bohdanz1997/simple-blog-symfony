FROM php:7-fpm

ADD php.ini /usr/local/etc/php/conf.d/

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get update && apt-get install zip unzip -y

# gd
#RUN buildRequirements="libpng12-dev libjpeg-dev" \
#	&& apt-get update && apt-get install -y ${buildRequirements} \
#	&& docker-php-ext-configure gd --with-jpeg-dir=/usr/lib \
#	&& docker-php-ext-install gd \
#	&& apt-get purge -y ${buildRequirements} \
#	&& rm -rf /var/lib/apt/lists/*

# zip
RUN apt-get update \
    && apt-get install -y zlib1g-dev \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install zip

RUN docker-php-ext-install pdo
RUN docker-php-ext-install pdo_mysql


RUN yes | pecl install xdebug
ADD xdebug.ini /usr/local/etc/php/conf.d/

ENV user dev
ARG PUID=1000
ARG PGID=1000
RUN groupadd -g $PGID $user && \
    useradd -u $PUID -g $user -m $user

USER $user