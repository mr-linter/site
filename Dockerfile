# syntax=docker/dockerfile:1.2

FROM spiralscout/roadrunner:2.12.3 as roadrunner
FROM php:8.1-alpine

FROM composer:2.5.4 as composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN set -x \
    # install permanent dependencies
    && apk add \
        icu-libs \
    # install build-time dependencies
    && apk add --virtual .build-deps \
        linux-headers \
        autoconf \
        openssl \
        make \
        g++

########################################################################
# Install PHP extensions
########################################################################
RUN CFLAGS="$CFLAGS -D_GNU_SOURCE" docker-php-ext-install opcache sockets

RUN pecl install -o redis 1>/dev/null \
    && echo 'extension=redis.so' > ${PHP_INI_DIR}/conf.d/redis.ini

########################################################################
# Enable opcache for CLI and JIT, docs: <https://www.php.net/manual/en/opcache.configuration.php#ini.opcache.jit>
########################################################################
RUN echo -e "\nopcache.enable=1\nopcache.enable_cli=1\nopcache.jit_buffer_size=32M\nopcache.jit=1235\n" >> \
        ${PHP_INI_DIR}/conf.d/docker-php-ext-opcache.ini \
    # show installed PHP modules
    && php -m \
    # create unprivileged user
    && adduser \
        --disabled-password \
        --shell "/sbin/nologin" \
        --home "/nonexistent" \
        --no-create-home \
        --uid "10001" \
        --gecos "" \
        "appuser" \
    # create directory for application sources and roadrunner unix socket
    && mkdir -p /app /var/run/rr \
    && chown -R appuser:appuser /app /var/run/rr \
    && chmod -R 777 /var/run/rr

# install roadrunner
COPY --from=roadrunner /usr/bin/rr /usr/bin/rr

# "fix" composer issue "Cannot create cache directory /tmp/composer/cache/..." for docker-compose usage
RUN chmod -R 777 ${COMPOSER_HOME}/cache

# use an unprivileged user by default
USER appuser:appuser

# use directory with application sources by default
WORKDIR /app

# copy composer (json|lock) files for dependencies layer caching
COPY --chown=appuser:appuser ./composer.* /app/

# install composer dependencies (autoloader MUST be generated later!)
RUN composer install -n --no-dev --no-cache --no-ansi --no-autoloader --no-scripts --prefer-dist

# copy application sources into image (completely)
COPY --chown=appuser:appuser . /app/

RUN set -x \
    # generate composer autoloader and trigger scripts
    && composer dump-autoload -n --optimize \
    # create the symbolic links configured for the application
    && php ./artisan storage:link

EXPOSE 8080

# unset default image entrypoint
ENTRYPOINT []
