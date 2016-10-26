#!/bin/bash

sudo apt-get install software-properties-common
sudo add-apt-repository ppa:ondrej/php -y

sudo apt-get update
sudo apt-get install apache2 libapache2-mod-fastcgi php7.0-fpm php7.0-curl

# enable php-fpm
sudo cp ~/.phpenv/versions/$(phpenv version-name)/etc/php-fpm.conf.default ~/.phpenv/versions/$(phpenv version-name)/etc/php-fpm.conf
sudo echo "listen = 127.0.0.1:9000" >> ~/.phpenv/versions/$(phpenv version-name)/etc/php-fpm.conf
sudo echo "listen.allowed_clients = 127.0.0.1" >> ~/.phpenv/versions/$(phpenv version-name)/etc/php-fpm.conf
sudo a2enmod rewrite actions fastcgi alias
echo "cgi.fix_pathinfo = 1" >> ~/.phpenv/versions/$(phpenv version-name)/etc/php.ini

# configure apache virtual hosts
sudo cp -f build/php7/travis-ci-apache /etc/apache2/sites-available/default
sudo sed -e "s?%TRAVIS_BUILD_DIR%?$(pwd)?g" --in-place /etc/apache2/sites-available/default

sudo service php7.0-fpm restart
sudo service apache2 restart

# debug fpm conf
echo FPM conf
cat ~/.phpenv/versions/$(phpenv version-name)/etc/php-fpm.conf | grep listen
# debug apache conf
echo Apache conf
apache2ctl -V
