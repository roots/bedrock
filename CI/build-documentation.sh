#!/usr/bin/env bash

#ln -s /Users/jeremydesvaux/Sites/wonderwp/framework/ /Users/jeremydesvaux/Sites/wonderwp/site/vendor/wonderwp/framework

echo "\n\n//==[ Build Documentation ]==========================\n";

echo "\n\n=> Generating Developer Documentation";
echo "\n- Gathering Documentation Parts";

rm -Rf web/documentation/dev/src/wonderwp-theme-core
cp -R web/app/themes/wonderwp-theme-core/documentation web/documentation/dev/src/wonderwp-theme-core

rm -Rf web/documentation/dev/src/wonderwp-plugin-core
cp -R web/app/mu-plugins/wonderwp-plugin-core/documentation web/documentation/dev/src/wonderwp-plugin-core

echo "\n- Serving doc";
pwd
vendor/bin/daux generate --source=web/documentation/dev/src/ --destination=web/documentation/dev/docs/ --delete
