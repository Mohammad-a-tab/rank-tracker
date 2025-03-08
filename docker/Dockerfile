FROM registry.gitlab.com/promasoud/php/8.2:latest
# Copy composer.lock and composer.json
COPY composer.json /var/www/

# Set working directory
WORKDIR /var/www

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

COPY --chown=www:www . /var/www

RUN /usr/local/bin/composer install --ignore-platform-reqs --prefer-dist --no-ansi --no-interaction --no-progress --no-scripts

RUN echo "Prepare Entrypoint ..." \
    # Prepare Entrypoint \
    && mv /var/www/docker/conf.d/* /usr/local/etc/php/conf.d/ \
    && mv /var/www/docker/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf \
    && mv /var/www/docker/nginx/default.conf /etc/nginx/sites-available/default \
    && mv /var/www/docker/nginx/nginx.conf /etc/nginx/nginx.conf \
    && mv /var/www/docker/start.sh /usr/local/bin/start \
    && chmod u+x /usr/local/bin/start \
    #
    #     Link Laravel storage
    && ln -s /var/www/storage/app/public /var/www/public/storage

CMD ["/usr/local/bin/start"]
