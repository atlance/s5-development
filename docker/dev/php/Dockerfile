FROM php:7.4.3-fpm as php-base

RUN apt-get update
RUN apt-get install $PHPIZE_DEPS
RUN apt-get install --no-install-recommends --no-install-suggests -y apt-utils apt-transport-https ca-certificates gettext-base openssh-client libpq-dev libonig-dev libxml2-dev libzip-dev librabbitmq-dev lsof nano unzip zip supervisor
RUN rm -rf /var/cache/apt/*

RUN docker-php-ext-install mbstring pdo pdo_mysql soap xml bcmath intl
RUN pecl install apcu opcache amqp && docker-php-ext-enable apcu opcache amqp
COPY config.d/40-custom.ini /usr/local/etc/php/conf.d/40-custom.ini

COPY supervisor/conf.d/consumer.conf  /var/tmp/supervisor/conf.d/consumer.conf
COPY supervisor/supervisord.conf    /var/tmp/supervisor/supervisord.conf

# FOR DEV
FROM php-base as php-dev

RUN apt-get install -y bash bash-completion mc git

ARG OS=${OS}
ARG UID=${UID}
ARG UNAME=${UNAME}
ARG UPASS=${UPASS}
ARG DOCKER_PROJECT_DIR=${DOCKER_PROJECT_DIR}

# prepare new user
RUN adduser --quiet --disabled-password --gecos "First Last,Room Number,Work Phone,Home Phone" -u ${UID} ${UNAME}
RUN adduser --quiet ${UNAME} www-data
RUN echo ${UNAME}:${UPASS} | chpasswd
RUN usermod -aG sudo ${UNAME}

# enable xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug

# prepare composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN chmod +x /usr/local/bin/composer

# prepare supervisord
RUN /bin/sh -c envsubst ${DOCKER_PROJECT_DIR} ${UNAME} ${UPASS} < /var/tmp/supervisor/conf.d/consumer.conf > /etc/supervisor/conf.d/consumer.conf
RUN /bin/sh -c envsubst ${DOCKER_PROJECT_DIR} ${UNAME} ${UPASS} < /var/tmp/supervisor/supervisord.conf > /etc/supervisor/supervisord.conf
RUN mkdir -p ${DOCKER_PROJECT_DIR}/var/run && touch ${DOCKER_PROJECT_DIR}/var/run/supervisor.sock
# important: without running supervisord (running without ready system - bad idea)
