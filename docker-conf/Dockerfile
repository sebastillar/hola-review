ARG BASE_IMAGE="php:7.4-cli"
ARG PACKAGIST_NAME="phpmd/phpmd"
ARG PHPQA_NAME="phpmd"
ARG VERSION="2.6.0"

FROM ${BASE_IMAGE}
ARG COMPOSER_IMAGE
ARG PACKAGIST_NAME
ARG VERSION
ARG PHPQA_NAME
ARG VERSION
ARG BUILD_DATE
ARG VCS_REF
ARG IMAGE_NAME

COPY ./docker-conf/php.ini /usr/local/etc/php/conf.d/docker-php-config.ini

RUN apt-get update && apt-get install -y \
    gnupg \
    g++ \
    procps \
    openssl \
    git \
    unzip \
    acl \
    && echo 'alias sf="php bin/console"' >> ~/.bashrc

RUN docker-php-ext-install \
    pdo pdo_mysql mysqli


#Composer
COPY --from=composer:1.6.5 /usr/bin/composer /usr/bin/composer
RUN COMPOSER_HOME="/composer" composer global require --prefer-dist --no-progress --dev ${PACKAGIST_NAME}:${VERSION}
ENV PATH /composer/vendor/bin:${PATH}

RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
RUN echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list
RUN apt-get update && apt-get install -y yarn

EXPOSE 8080

WORKDIR /var/www/app

CMD [ "php", "-S", "0.0.0.0:8080" ]
