### gh-1.1: 2014-03-20

* add virtual machine support (vagrant)
* add WordPress multi-site support
* adjust documentation and usage recommendations to fit expected use case
* add provisioning (knife solo setup)
* add initial hostname abstraction
* use packagist for WordPress

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
