#!/usr/bin/env bash
sed -i 's/listen = \/run\/php\/php8.1-fpm.sock/listen = 0.0.0.0:19000/g' /etc/php/8.1/fpm/pool.d/www.conf
service php8.1-fpm start
