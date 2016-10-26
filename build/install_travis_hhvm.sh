#!/bin/bash

# apache modules
sudo a2enmod rewrite actions fastcgi alias

# configure apache virtual hosts
sudo cp -f build/apache_hhvm/travis-ci-apache /etc/apache2/sites-available/default
sudo sed -e "s?%TRAVIS_BUILD_DIR%?$(pwd)?g" --in-place /etc/apache2/sites-available/default

# services
sudo service apache2 restart
hhvm -m daemon -vServer.Type=fastcgi -vServer.Port=9000 -vServer.FixPathInfo=true
