#!/usr/bin/env sh

set -e

role=${CONTAINER_ROLE:-app}

if [ "$role" = "app" ]; then

    exec php-fpm

elif [ "$role" = "nginx" ]; then

    echo "Run supervisord"
    exec  /usr/bin/supervisord -c /var/www/docker/supervisor.conf

elif [ "$role" = "queue" ]; then

    echo "Run supervisord"
    exec  /usr/bin/supervisord -c /var/www/supervisor.conf


elif [ "$role" = "scheduler" ]; then

   while [ true ]
   do
     php /var/www/artisan schedule:run --verbose --no-interaction &
     sleep 60
   done

    # exec cron -f && tail -f /var/log/cron.log

else
    echo "Could not match the container role \"$role\""
    exit 1
fi
