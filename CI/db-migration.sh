#!/usr/bin/env bash

echo "\n\n//==[ Build Step 4 : Sending DB Migration Scripts]==========================\n";

echo "Copying migration files to the server";
rsync -uvr --delete $WORKSPACE/CI/DB/scripts/* $SSHUSERNAME@$SSHSERVER:$DBFOLDER;