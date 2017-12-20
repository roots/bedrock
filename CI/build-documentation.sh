#!/usr/bin/env bash

#ln -s /Users/jeremydesvaux/Sites/wonderwp/framework/ /Users/jeremydesvaux/Sites/wonderwp/site/vendor/wonderwp/framework

echo "\n\n//==[ Build Step 2 : Build Documentation ]==========================\n";

echo "\n=> Generating PHPDOC";
php -d memory_limit=1024M vendor/bin/apigen generate vendor/wonderwp/framework/src vendor/pimple/pimple web/wp/wp-admin/includes web/wp/wp-includes --destination web/documentation/phpdoc

echo "\n\n=> Generating Developer Documentation";
echo "\n- Gathering Documentation Parts";
rm -Rf web/documentation/dev/src/wonderwp_framework
cp -R vendor/wonderwp/framework/documentation/ web/documentation/dev/src/wonderwp_framework

rm -Rf web/documentation/dev/src/wonderwp-theme-core
cp -R web/app/themes/wonderwp-theme-core/documentation web/documentation/dev/src/wonderwp-theme-core

rm -Rf web/documentation/dev/src/wonderwp-plugin-core
cp -R web/app/mu-plugins/wonderwp-plugin-core/documentation web/documentation/dev/src/wonderwp-plugin-core

echo "\n- Serving doc";
pwd
vendor/bin/daux generate --source=web/documentation/dev/src/ --destination=web/documentation/dev/dest/ --delete
