#!/usr/bin/env bash

echo "\n\n//==[ Build Step 1 : Build Local ]==========================\n";

cd ../
composer install
composer update wonderwp/framework
npm install
#node_modules/bower/bin/bower install
node_modules/gulp/bin/gulp.js build