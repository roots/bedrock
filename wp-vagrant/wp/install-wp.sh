#!/usr/bin/env bash

if $download_wordpress ; then

  echo "**** downloading WP $wp_version"

	cd $wp_path;

  # if wp_version is specified, then add this
  download_string=""
  if [ ! -z $wp_version ]; then
    download_string=" --version="$wp_version
  fi

  # download core files
  # downloading wordpress
  sudo -u vagrant -i -- wp core download --path=$wp_path $download_string --quiet
fi

if $install_wordpress ; then
  echo "**** installing WP"

  # create wp-config.php
  echo 'creating wp-config.php'
  if [ -z "$wp_db_user" ]; then
    wp_db_user='root'
  fi
  if [ -z "$wp_db_password" ]; then
    wp_db_password='root'
  fi
  echo "wp core config --path=$wp_path --dbname=$wp_db_name --dbuser=$wp_db_user --dbpass=$wp_db_password"

  sudo -u vagrant -i --  wp core config  --path=$wp_path --dbname=$wp_db_name --dbuser=$wp_db_user --dbpass=$wp_db_password --extra-php <<PHP
    define( 'WP_DEBUG', true );
    define( 'WP_DEBUG_LOG', true );
PHP

  # install database
  wp core install --allow-root \
                  --path=$wp_path \
								  --url=${hostname} \
									--admin_user=$wp_admin_user \
									--admin_password=$wp_admin_password \
									--admin_email=$wp_admin_email \
									--title="$wp_site_title" \
									--skip-email


fi
