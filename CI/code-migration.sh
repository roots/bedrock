#!/usr/bin/env bash

echo "\n\n//==[ Build Step 3 : Code Migration ]==========================\n";

echo "Hello this is build $BUILD_NUMBER";
echo "Built into the workspace $WORKSPACE";
echo "This build will now be sent to the $ENV environmnent";
echo "rsync -uvrn --delete --exclude-from $WORKSPACE/CI/exclude-file.txt $WORKSPACE/* $SSHUSERNAME@$SSHSERVER:$CHEMINDIST";
rsync -uvr --delete --exclude-from $WORKSPACE/CI/exclude-file.txt $WORKSPACE/* $SSHUSERNAME@$SSHSERVER:$CHEMINDIST;