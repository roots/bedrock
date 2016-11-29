#!/usr/bin/env bash

#ln -s /Users/jeremydesvaux/Sites/wonderwp/framework/ /Users/jeremydesvaux/Sites/wonderwp/site/vendor/wonderwp/framework

echo "\n\n//==[ Build Step 2 : Build Documentation ]==========================\n";

cd ../;

echo "\n=> Generating PHPDOC";
#vendor/apigen/apigen/bin/apigen generate

echo "\n\n=> Generating Developer Documentation";
echo "\n- Gathering Documentation Parts";
rm -Rf web/documentation/dev/src/wonderwp_framework
cp -R vendor/wonderwp/framework/documentation/ web/documentation/dev/src/wonderwp_framework
cp -R web/app/themes/wonderwp_theme/documentation web/documentation/dev/src/wonderwp_theme
echo "\n- Serving doc";
vendor/jeremy-wdf/daux.io/bin/daux generate -s web/documentation/dev/src/ -d  web/documentation/dev/dest/ --delete