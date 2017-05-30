#!/usr/bin/env bash


# if $wp_db_name is specified, then create the database and user (if neccesary)

if [ ! -z $wp_db_name ] ; then

  echo "**** creating database"
  mysql -u root -p$mysql_root_password -e "CREATE DATABASE IF NOT EXISTS $wp_db_name;"

  if [ ! -z "$wp_db_user" ]; then
	  echo "**** adding custom user"
      mysql -u root -p$mysql_root_password -e "GRANT ALL ON $wp_db_name.* TO '$wp_db_user'@'localhost' IDENTIFIED BY '$wp_db_password'"
  fi

else
	echo "**** No database name specified - skipping db creation"
fi
