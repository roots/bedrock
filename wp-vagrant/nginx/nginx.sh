#!/usr/bin/env bash

# copy nginx config
cp /vagrant/wp-vagrant/nginx/nginx.conf /etc/nginx/

# remove default site
if [ -f /etc/nginx/sites-enabled/default ]; then
  rm /etc/nginx/sites-enabled/default
fi
if [ -f /etc/nginx/sites-enabled/default.conf ]; then
  rm /etc/nginx/sites-enabled/default.conf
fi

# Create an SSL key and certificate for HTTPS support.
if [[ ! -e /etc/nginx/server.key ]]; then
  echo "Generate Nginx server private key..."
  vvvgenrsa="$(openssl genrsa -out /etc/nginx/server.key 2048 2>&1)"
  echo "$vvvgenrsa"
fi
if [[ ! -e /etc/nginx/server.crt ]]; then
  echo "Sign the certificate using the above private key..."
  vvvsigncert="$(openssl req -new -x509 \
          -key /etc/nginx/server.key \
          -out /etc/nginx/server.crt \
          -days 3650 \
          -subj /CN=*.wpvagrant.dev/CN=*.wordpress.dev/CN=*.vvv.dev 2>&1)"
  echo "$vvvsigncert"
fi

# copy our site config and symlink it
cp /vagrant/wp-vagrant/nginx/default.conf /etc/nginx/sites-available/
ln -s /etc/nginx/sites-available/default.conf /etc/nginx/sites-enabled/default.conf

# rename vhost server name to hostname
echo "nginx vhost conf..."
sed -i "s/%%hostname%%/${hostname}/" /etc/nginx/sites-enabled/default.conf

# php version for fpm
sed -i "s/%%php_version%%/${php_version}/" /etc/nginx/sites-enabled/default.conf
