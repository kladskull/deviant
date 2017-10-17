#!/bin/bash
mkdir ./app/log/
mkdir ./app/templates/config/
mkdir ./app/templates/cache/
mkdir ./app/templates/templates_c/
chown -R www-data:root ./
chmod -R a=r,u+w,a+X .
chmod 755 ./fix_perms.sh
chmod -R 644 ./app/log/
chmod -R 644 ./app/templates/config/
chmod -R 644 ./app/templates/cache/
chmod -R 644 ./app/templates/templates_c/
chmod -R 755 ./app/log
chmod -R 755 ./app/templates/config
chmod -R 755 ./app/templates/cache
chmod -R 755 ./app/templates/templates_c

