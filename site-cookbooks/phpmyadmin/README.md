Description
===========

Chef Cookbook for installing and configuring phpMyAdmin.
Supports configuration for apache2 and nginx.

Requirements
============

## Platforms:

Tested on:

* Ubuntu 12.04 with apache2

## Cookbooks:

* Mysql::Server
* Openssl
* Nginx optional
* Apache2 (https://github.com/opscode-cookbooks/apache2) optional

Attributes
==========

* default[:phpmyadmin][:cfg][:cfg_path]               =   '/etc/phpmyadmin'
* default[:phpmyadmin][:cfg][:path]                   =   '/usr/share/phpmyadmin'

* default[:phpmyadmin][:cfg][:auth_type]              =   'cookie'
* default[:phpmyadmin][:cfg][:allow_root]             =   false
* default[:phpmyadmin][:cfg][:allow_no_password]      =   false

* default[:phpmyadmin][:cfg][:control_database]       =   'phpmyadmin'
* default[:phpmyadmin][:cfg][:control_user]           =   'phpmyadmin'

By default an apache2 site for phpmyadmin will be set up. 
You can configure nginx by setting  ['phpmyadmin']['webserver'] to 'nginx'.
You can prevent chef from doing this by setting ['phpmyadmin']['webserver'] to false.

* default[:phpmyadmin][:webserver]                    =   'apache2'

* default[:phpmyadmin][:nginx][:port]                 =   80
* default[:phpmyadmin][:nginx][:server_name]          =   'phpmyadmin.yourhost.com'
* default[:phpmyadmin][:nginx][:docroot]              =   default[:phpmyadmin][:cfg][:path]
* default[:phpmyadmin][:nginx][:fastcgi_server]       =   'unix:/dev/shm/php5-fpm.sock'

The location for the phpmyadmin site configuration included in the phpmyadmin package can be set by changing 
the following value.

* default[:phpmyadmin][:apache2][:site_config]        =   '/etc/phpmyadmin/apache.conf'

Usage
=====

Simply include the phpmyadmin recipe.

License and Author
==================

Author:: Sebastian Johnsson (<sebastian@agiley.se>)
Author:: Anusch Athari (<anusch@athari.de>)

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
