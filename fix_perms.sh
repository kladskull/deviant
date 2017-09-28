#!/bin/bash
chown -R mcurry:www-data /var/www
chmod -R a=r,u+w,a+X /var/www
chmod 755 /var/www/html/fix_perms.sh

