#!/usr/bin/env bash

echo "\n//==[ Build Step 4 : Executing DB Migration Scripts ]==========================\n";

if [ -z "$ENV" ]
then
    ENV='dev';
fi

#Declare variables

if test $ENV = 'dev'
then
    MYSQLUSER='devpkleurope2016';
    MYSQLPWD='dcfrrx45';
    MYSQLDB='devpkleurope2016';
    CHEMINDIST='/var/virtual_www/pinkladyeurope2016.com/dev.www.pinkladyeurope2016.com/htdocs';
fi

if test $ENV = 'preprod'
then
    MYSQLUSER='preprodpkleurope';
    MYSQLPWD='fkcdr8ar';
    MYSQLDB='preprodpkleurope';
    CHEMINDIST='/var/virtual_www/pinkladyeurope2016.com/preprod.www.pinkladyeurope2016.com/htdocs';
fi

    MYSQLSERVER='127.0.0.1';
    DBFOLDER="$CHEMINDIST/web/app/uploads/db";
    SERVER='178.20.64.200';

if test $ENV = dev
then
    PREPRODMYSQLSERVER='127.0.0.1';
    PREPRODMYSQLUSER='preprodpkleurope';
    PREPRODMYSQLPWD='fkcdr8ar';
    PREPRODMYSQLDB='preprodpkleurope';

    echo "-- Dumping preprod database into $ENV one";
    mysqldump -h $PREPRODMYSQLSERVER -u $PREPRODMYSQLUSER --password=$PREPRODMYSQLPWD $PREPRODMYSQLDB | mysql -h $MYSQLSERVER -u $MYSQLUSER --password=$MYSQLPWD $MYSQLDB;
fi

echo "-- Executing migration scripts";

UPDATEDB=1
while [ $UPDATEDB = 1 ]
do
    echo "\t---------";
    echo "\tChecking current DB version";
    DBVERSION=$(echo "SELECT version as v FROM DB_history ORDER BY update_on DESC, version DESC LIMIT 1" | mysql -h $MYSQLSERVER $MYSQLDB -u$MYSQLUSER -p$MYSQLPWD -N);
    UPDATEFILE="$DBFOLDER/upgradeFrom_$DBVERSION.sql";
    echo "\tVersion : $DBVERSION";
    echo "\tChecking if an update script exists for this version: ($UPDATEFILE)";
    if [ -f "$UPDATEFILE" ]
    then
        echo "\tAn upgrade script has been found : $UPDATEFILE."
        echo "\tExecuting script";
        mysql -h $MYSQLSERVER -u $MYSQLUSER --password=$MYSQLPWD $MYSQLDB < $UPDATEFILE;
    else
        echo "\tUpgrade script not found. ($UPDATEFILE)."
        UPDATEDB=0;
    fi
    echo "\t---------\n";
done