#!/usr/bin/env bash

if $install_wordpress ; then
  echo "**** installing WP"

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
