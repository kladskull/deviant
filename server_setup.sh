#!/bin/bash

# root only
if [ "$(id -u)" -ne 0 ]; then
        echo 'This script must be run by root' >&2
        exit 1
fi

# upgrade ec2 instance
apt-get update -y
apt-get upgrade -y

# install maria-db client
apt-get install -y apache2 mariadb-client

# add our user to the apache group
usermod -a -G www-data ubuntu

# modify web directory permissions
chown -R ubuntu:www-data /var/www

# ensure all future files are created correctly
chmod 2775 /var/www && find /var/www -type d -exec sudo chmod 2775 {} \;

# change all current files
find /var/www -type f -exec sudo chmod 0664 {} \;

# install PHP Extras
apt-get install -y php php-zip php-mbstring php-curl php-xml libapache2-mod-php php-mysql git composer

apt autoremove -y

# restart the web server
service apache2 restart

