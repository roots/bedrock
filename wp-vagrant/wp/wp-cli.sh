#!/usr/bin/env bash

# update wp-cli
if [  -f /usr/local/bin/wp ]; then
  echo "**** updating wp-cli"
  sudo wp cli update --allow-root --yes
fi

wpcli_defaults_folder='/home/vagrant/.wp-cli'
if [ ! -d $wpcli_defaults_folder  ]; then
  echo "**** adding wp-cli defaults"
  mkdir $wpcli_defaults_folder
  cp /vagrant/wp-vagrant/wp/wp-cli.config.yml $wpcli_defaults_folder/config.yml
fi
