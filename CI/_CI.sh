#!/usr/bin/env bash
echo "\n//==[ Starting CI ]==========================\n";

echo $JENKINSENV;
if test $JENKINSENV = 'local'
then
    export PATH=/usr/local/bin:/usr/local/bin/node:$PATH;
fi

echo "Checking Injected Variables";
if [ -z "$ENV" ]
then
    echo "We could not detect injected variables.";
    echo "Please specify the following variables: ENV, SSHUSERNAME, SSHSERVER, CHEMINDIST, MYSQLSERVER, MYSQLUSER, MYSQLPWD, MYSQLDB, STEPCOUNTER,";
fi

echo "Navigating to $WORKSPACE/CI";
cd $WORKSPACE/CI;

echo "Launching build steps\n";
sh ./build-local.sh
sh ./code-migration.sh
sh ./db-migration.sh