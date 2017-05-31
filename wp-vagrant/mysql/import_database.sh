#!/usr/bin/env bash


# if $wp_db_name is specified, then create the database and user (if neccesary)
# if import_database is specified then import database and use wp-cli to rename domain

if [ ! -z $wp_db_name ] && $import_database; then

  # look for a sql file in the wp-vagrant folder
  number_of_sql_files=$(find /vagrant/wp-vagrant -maxdepth 1 -name '*.sql' | wc -l)

  case $number_of_sql_files in
    0)
      echo "**** No SQL file found - cannot import"
      ;;
    1)
      echo "**** SQL file found - proceeding with import"
      wp_db_dump_file=$(find /vagrant/wp-vagrant -maxdepth 1 -name '*.sql')
      echo "**** import filename is: $wp_db_dump_file"
      mysql -u root -p$mysql_root_password $wp_db_name < $wp_db_dump_file

      if [ ! -z $import_site_domain ]; then
        echo "**** wp-cli search and replace"
        wp --path=$wp_path --allow-root search-replace $import_site_domain $hostname
      fi

      ;;
    *)
      echo "**** Multiple SQL files found - aborting import"
      ;;
    esac

else

	echo "**** No database name specified - skipping db import"

fi
