#!/bin/bash

php /var/www/html/composer.phar self-update
cd /var/www/html
php /var/www/html/composer.phar install