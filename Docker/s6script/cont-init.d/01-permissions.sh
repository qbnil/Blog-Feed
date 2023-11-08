#!/usr/bin/env bash
#chown -R 1000:1000 /var/www/dev-docker
chmod -R 777 /var/www/public/upload/
mkdir -p -m=777 /var/www/public/upload/media
usermod -u 1000 www-data
groupmod -g 1000 www-data