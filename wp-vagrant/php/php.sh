#!/usr/bin/env bash


# backup existing php.ini
mv /etc/php/${php_version}/fpm/php.ini /etc/php/${php_version}/fpm/php.ini.default

# copy config files to the relevant php version's config
cp /vagrant/wp-vagrant/php/php.ini  /etc/php/${php_version}/fpm/php.ini
cp /vagrant/wp-vagrant/php/20-xdebug.ini /etc/php/${php_version}/fpm/conf.d/
cp /vagrant/wp-vagrant/php/www.conf /etc/php/${php_version}/fpm/pool.d/

# point to correct .sock file in the nginx v
sed -i "s/%%php_version%%/${php_version}/" /etc/php/${php_version}/fpm/pool.d/www.conf

update-alternatives --set php /usr/bin/php${php_version}
