#!/usr/bin/env bash

if [ ! -d /home/vagrant/.byobu ]; then
  mkdir /home/vagrant/.byobu
fi

cp /vagrant/wp-vagrant/configs/.byobu/keybindings.tmux /home/vagrant/.byobu/
cp /vagrant/wp-vagrant/configs/.byobu/status /home/vagrant/.byobu/
sudo chown -R vagrant:vagrant /home/vagrant/.byobu/