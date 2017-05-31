#!/usr/bin/env bash

# Do we have an .env file
if [ -f /vagrant/.env ]; then
  echo "**** loading settings from .env"
  # export as variables
  export $(egrep -v '^#' /vagrant/.env | xargs);
fi

###############################################################################
# Basic settings - for new and existing WP installations
#

# this is hostname for the vagrant box
# make sure to change it in the Vagrantfile as well
hostname='wpvagrant.dev'

# PHP version to install
# valid values:
# 5.6
# 7.0
# 7.1
php_version='7.0'

# specify path (inside the Vagrant VM) to WordPress to allow wp-cli to do search and replace
# shouldn't need to change this from /vagrant unless you've made other config changes
wp_path='/vagrant/web/wp'

#mysql root password, shouldn't need to change this
mysql_root_password='root'


###############################################################################
#
# Settings for creating a new site.
# You do not have to change this section if you're dropping
# WP Vagrant into an existing WP folder
#

# set to true to download and install latest version of WP
# if we detect existing core files, then the WP download will not take place, even if
# this is set to true, so it's normally safe to always have this set to true

install_wordpress=true



#
# database
#

# name of database: eg wordpress
wp_db_name=${DB_NAME?'bedrock'}

# database user name, leave empty to use the root user
wp_db_user=${DB_USER?'wpdev'}

# database password
wp_db_password=${DB_PASSWORD?'wpdev'}

#
# initial WP admin user
# ignored if install_wordpress is false
#

wp_admin_user='admin'
wp_admin_password='123'
wp_admin_email='root@example.com'
wp_site_title='Bedrock'

#
# end of settings for a new site
###############################################################################


###############################################################################
#
# Settings for using wp-vagrant with an existing site
#

# set to true to import the database as part of the provisioning process
import_database=false

# specify the domain that the imported dump file uses.
# This allows us to search / replace the domain used in the dump file into
# the hostname used by this vagrant instance

import_site_domain=''
