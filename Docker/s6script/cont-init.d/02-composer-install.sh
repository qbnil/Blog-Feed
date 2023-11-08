#!/usr/bin/with-contenv bash
export HOME=/var/www
#s6-setuidgid 1000:100 ssh-keyscan -H gitlab.srvdev.ru > ~/.ssh/known_hosts
cd /var/www
#s6-setuidgid 1000:1000 composer install --no-interaction
