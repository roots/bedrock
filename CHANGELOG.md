### 1.7.2: 2016-09-07

* Update to WordPress 4.6.1

### 1.7.1: 2016-08-16

* Update to WordPress 4.6

### 1.7.0: 2016-07-10

* Bump PHP requirement to >= 5.6 (5.5 is no longer supported)

### 1.6.4: 2016-06-21

* Update to WordPress 4.5.3

### 1.6.3: 2016-05-06

* Update to WordPress 4.5.2

### 1.6.2: 2016-04-26

* Update to WordPress 4.5.1

### 1.6.1: 2016-04-12

* Update to WordPress 4.5
* Update coding standards (PSR-2) ([#244](https://github.com/roots/bedrock/pull/244))

### 1.6.0: 2016-03-03

* Add wp-password-bcrypt for more secure passwords ([#243](https://github.com/roots/bedrock/pull/243))

### 1.5.4: 2016-02-29

* Use HTTPS for wpackagist.org

### 1.5.3: 2016-02-03

* Update to WordPress 4.4.2

### 1.5.2: 2016-02-01

* Bump `composer/installers` dependency to 1.0.23 to fix deprecation notice

### 1.5.1: 2016-01-27

* Use [oscarotero/env](https://github.com/oscarotero/env) instead of `getenv` ([#229](https://github.com/roots/bedrock/pull/233))

### 1.5.0: 2016-01-17

* Fix `DISABLE_WP_CRON` setting via ENV variable ([#229](https://github.com/roots/bedrock/pull/229))
* Set default `DB_CHARSET` to `utf8mb4`

### 1.4.7: 2016-01-07

* Update to WordPress 4.4.1

### 1.4.6: 2015-12-09

* Update to WordPress 4.4

### 1.4.5: 2015-09-16

* Update to WordPress 4.3.1
* Bump minimum required PHP version to 5.5 ([#201](https://github.com/roots/bedrock/pull/201))

### 1.4.4: 2015-08-18

* Update to WordPress 4.3

### 1.4.3: 2015-08-04

* Update to WordPress 4.2.4

### 1.4.2: 2015-07-24

* Update to WordPress 4.2.3

### 1.4.1: 2015-06-30

* Dotenv 2.0.1 update

### 1.4.0: 2015-06-07

* Removed .env generation script

### 1.3.7: 2015-05-07

* Update to WordPress 4.2.2

### 1.3.6: 2015-04-27

* Update to WordPress 4.2.1

### 1.3.5: 2015-04-23

* Update to WordPress 4.2
* Update to WordPress 4.1.2
* Don't register theme directory if `WP_DEFAULT_THEME` is defined
* Move Capistrano configs to https://github.com/roots/bedrock-capistrano

### 1.3.4: 2015-02-18

* WordPress 4.1.1 fix

### 1.3.3: 2015-02-18

* Update to WordPress 4.1.1
* mu-plugins autoloader Multisite fix
* Coding standards update + TravisCI integration

### 1.3.2: 2014-12-18

* Update to WordPress 4.1
* Remove WPLANG constant

### 1.3.1: 2014-11-28

* Add Capistrano task to fix/update WP theme paths after deploys

### 1.3.0: 2014-11-20

* Update to WordPress 4.0.1
* Use johnpbloch/wordpress package instead of custom repository
* Update default deploy.rb
* Require PHP >= 5.4 in composer.json
* Better PSR-1 adherence
* Update phpdotenv dependency to 1.0.9
* Fix Composer installer path plugin order
* Add bedrock-autoloader mu-plugin

### 1.2.7: 2014-09-04

* Update to WordPress 4.0

### 1.2.6: 2014-08-06

* Update to WordPress 3.9.2
* Minor deploy fix
* Doc updates

### 1.2.5: 2014-07-16

* Update to WordPress 3.9.1
* Doc updates
* Add `DB_PREFIX` constant
* Update Gem versions
* Disallow indexing in non-production environments

### 1.2.4: 2014-04-17

* Fixes issue with 3.9 update (`composer.lock` wasn't updated)

### 1.2.3: 2014-04-16

* Update to WordPress 3.9

### 1.2.2: 2014-04-14

* Update to WordPress 3.8.3
* Only run `Dotenv::load` if `.env` file exists

### 1.2.1: 2014-04-08

* Update to WordPress 3.8.2

### 1.2.0: 2014-04-07

* WP package now has `wordpress` vendor name: `wordpress/wordpress`
* Remove wp-cli and add `wp-cli.yml` config

### 1.1.1: 2014-03-11

* Update phpdotenv to 1.0.6
* Update wp-cli to v0.14.1
* Update README to refence new WordPress Packagist namespaces
* Fix uploads path in `linked_dirs` for Capistrano deploys

### 1.1.0: 2014-03-01

* Update to Capistrano 3.1.0: `deploy:restart` is no longer run by default
* Better webroot structure: introduces the `/web` directory as the document/web root for web server vhosts

### 1.0.0: 2013-12-18

* Initial release
