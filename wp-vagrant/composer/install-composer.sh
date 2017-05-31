#!/usr/bin/env bash

# Install Composer if it is not yet available.
if [[ ! -n "$(composer --version --no-ansi | grep 'Composer version')" ]]; then
  echo "*** Installing Composer..."
  curl -sS "https://getcomposer.org/installer" | php
  chmod +x "composer.phar"
  mv "composer.phar" "/usr/local/bin/composer"
fi

echo "**** Running composer install"
cd /vagrant
composer install
