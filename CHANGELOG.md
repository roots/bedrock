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
