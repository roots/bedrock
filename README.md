# [Bedrock](http://roots.io/wordpress-stack/)

Bedrock is a modern WordPress stack that helps you get started with the best development tools and project structure.

Bedrock's main features:

* Dependency management with [Composer](http://getcomposer.org)
* Automated deployments with [Capistrano](http://www.capistranorb.com/)
* Better folder structure
* Easy WordPress configuration with environment specific files
* Environment variables with [Dotenv](https://github.com/vlucas/phpdotenv)
* Easy development environments with [Vagrant](http://www.vagrantup.com/) - coming soon!

Bedrock is meant as a base for you to fork and modify to fit your needs. It is delete-key friendly and you can strip out or modify any part of it. You'll also want to customize Bedrock with settings specific to your sites/company.

Much of the philosphy behind Bedrock is inspired by the [Twelve-Factor App](http://12factor.net/) methodology including the [WordPress specific version](http://roots.io/twelve-factor-wordpress/).

Note: While this is a project from the guys behind the [Roots starter theme](http://roots.io/starter-theme/), Bedrock isn't tied to Roots in any way and works with any theme.

## Requirements

* Git
* PHP >= 5.3.2 (for Composer)
* Ruby >= 1.9 (for Capistrano)

If you aren't interested in using a part, then you don't need its requirements either. Not deploying with Capistrano? Then don't worry about Ruby for example.

## Installation/Usage

See [Documentation](#documentation) for more details on the steps below.

### Using `create-project`

Composer's `create-project` command will automatically install the Bedrock project to a directory and run `composer install`.

The post-install script will automatically copy `.env.example` to `.env` and you'll be prompted about generating salt keys and appending them to your `.env` file.

Note: To generate salts without a prompt, run `create-project` with `-n` (non-interactive). You can also change the `generate-salts` setting in `composer.json` under `config` in your own fork. The default is `true`.

1. Run `composer create-project roots/bedrock <path>` (`path` being the folder to install to)
2. Edit `.env` and update environment variables:
  * `DB_NAME` - Database name
  * `DB_USER` - Database user
  * `DB_PASSWORD` - Database password
  * `DB_HOST` - Database host (defaults to `localhost`)
  * `WP_ENV` - Set to environment (`development`, `staging`, `production`, etc)
  * `WP_HOME` - Full URL to WordPress home (http://example.com)
  * `WP_SITEURL` - Full URL to WordPress including subdirectory (http://example.com/wp)
3. Add theme(s)
4. Access WP Admin at `http://example.com/wp/wp-admin`

### Manually

1. Clone/Fork repo
2. Run `composer install`
3. Copy `.env.example` to `.env` and update environment variables:
  * `DB_NAME` - Database name
  * `DB_USER` - Database user
  * `DB_PASSWORD` - Database password
  * `DB_HOST` - Database host (defaults to `localhost`)
  * `WP_ENV` - Set to environment (`development`, `staging`, `production`, etc)
  * `WP_HOME` - Full URL to WordPress home (http://example.com)
  * `WP_SITEURL` - Full URL to WordPress including subdirectory (http://example.com/wp)
4. Add theme(s)
5. Access WP Admin at `http://example.com/wp/wp-admin`

Using Capistrano for deploys?

6. Edit stage/environment configs in `config/deploy/` to set the roles/servers and connection options.

## Documentation

### Folder Structure

```
├── app
│   ├── mu-plugins
│   ├── plugins
│   └── themes
├── Capfile
├── composer.json
├── config
│   │── deploy
│   │   ├── staging.rb
│   │   └── production.rb
│   │── deploy.rb
│   │── environments
│   │   ├── development.php
│   │   ├── staging.php
│   │   └── production.php
│   └── application.php
├── Gemfile
├── index.php
├── vendor
├── wp-config.php
└── wp
```

The organization of Bedrock is similar to putting WordPress in its own subdirectory but with some improvements.

* `wp-content` (or maybe just `content`) has been named `app` to better reflect its contents. It contains application code and not just "static content". It also matches up with other frameworks such as Symfony and Rails.
* `wp-config.php` remains in the root because it's required by WP, but it only acts as a loader. The actual configuration files have been moved to `config/` for better separation.
* Capistrano configs are also located in `config/` to make it consistent.
* `vendor/` is where the Composer managed dependencies are installed to.
* `wp/` is where the WordPress core lives. It's also managed by Composer but can't be put under `vendor` due to WP limitations.

### Configuration Files

The root `wp-config.php` is required by WordPress and is only used to load the other main configs. Nothing else should be added to it.

`config/application.php` is the main config file that contains what `wp-config.php` usually would. Base options should be set in there.

For environment specific configuration, use the files under `config/environments`. By default there's is `development`, `staging`, and `production` but these can be whatever you require.

The environment configs are required **before** the main `application` config so anything in an environment config takes precedence over `application`.

Note: You can't re-define constants in PHP. So if you have a base setting in `application.php` and want to override it in `production.php` for example, you have a few options:

* Remove the base option and be sure to define it in every environment it's needed
* Only define the constant in `application.php` if it isn't already defined.

**Security warning**: You'll want to block configuration files from being publicly accessible (we'll do this automatically once we have Vagrant/server configs)

Nginx:

```nginx
location ~ /(config|Capfile|Gemfile(\.lock)?|composer(\.lock|\.json)) {
  deny all;
}
```

Apache (in `.htaccess`):

```apache
<FilesMatch "/(config|Capfile|Gemfile(\.lock)?|composer(\.lock|\.json))">

    # Apache < 2.3
    <IfModule !mod_authz_core.c>
        Order allow,deny
        Deny from all
        Satisfy All
    </IfModule>

    # Apache ≥ 2.3
    <IfModule mod_authz_core.c>
        Require all denied
    </IfModule>

</FilesMatch>
```

#### Don't want it?

You will lose the ability to define environment specific settings.

* Move all configuration into `wp-config.php`
* Manually deal with environment specific options
* Remove `config` directory

### Environment Variables

Bedrock tries to separate config from code as much as possible and environment variables are used to achieve this. The benefit is there's a single place (`.env`) to keep settings like database or other 3rd party credentials that isn't committed to your repository.

[PHP dotenv](https://github.com/vlucas/phpdotenv) is used to load the `.env` file. All variables are then available in your app by `getenv`, `$_SERVER`, or `$_ENV`.

Currently, the following env vars are required:

* `DB_USER`
* `DB_NAME`
* `DB_PASSWORD`
* `WP_HOME`
* `WP_SITEURL`

#### Don't want it?

You will lose the separation between config and code and potentially put secure credentials at risk.

* Remove `dotenv` from `composer.json` requires
* Remove `.env.example` file from root
* Remove `require_once('vendor/autoload.php');` from `wp-config.php`
* Replace all `getenv` calls with whatever method you want to set those values

### Composer

[Composer](http://getcomposer.org) is used to manage dependencies. Bedrock considers any 3rd party library as a dependency including WordPress itself and any plugins.

See these two blogs for more extensive documentation:

* [Using Composer with WordPress](http://roots.io/using-composer-with-wordpress/)
* [WordPress Plugins with Composer](http://roots.io/wordpress-plugins-with-composer/)

Screencast ($): [Using Composer With WordPress](http://roots.io/screencasts/using-composer-with-wordpress/)

#### Plugins

[WordPress Packagist](http://wpackagist.org/) is already registered in the `composer.json` file so any plugins from the [WordPress Plugin Directory](http://wordpress.org/plugins/) can easily be required.

To add a plugin, add it under the `require` directive or use `composer require <namespace>/<packagename>` from the command line. If it's from WordPress Packagist then the namespace is always `wpackagist`.

Whenever you add a new plugin or update the WP version, run `composer update` to install your new packages.

`plugins`, and `mu-plugins` are Git ignored by default since Composer manages them. If you want to add something to those folders that *isn't* managed by Composer, you need to update `.gitignore` to whitelist them:

`!app/plugins/plugin-name`

#### Updating WP and plugin versions

Updating your WordPress version (or any plugin) is just a matter of changing the version number in the `composer.json` file.

Then running `composer update` will pull down the new version.

#### Don't want it?

Composer integration is the biggest part of Bedrock, so if you were going to remove it there isn't much point in using Bedrock.

### Capistrano

[Capistrano](http://www.capistranorb.com/) is a remote server automation and deployment tool. It will let you deploy or rollback your application in one command:

* Deploy: `cap production deploy`
* Rollback: `cap production deploy:rollback`

Composer support is built-in so when you run a deploy, `composer install` is automatically run. Capistrano has a great [deploy flow](http://www.capistranorb.com/documentation/getting-started/flow/) that you can hook into and extend it.

It's written in Ruby so it's needed *locally* if you want to use it. Capistrano was recently rewritten to be completely language agnostic, so if you previously wrote it off for being too Rails-centric, take another look at it.

Screencast ($): [Deploying WordPress with Capistrano](http://roots.io/screencasts/deploying-wordpress-with-capistrano/)

#### Don't want it?

You will lose the one-command deploys and built-in integration with Composer. Another deploy method will be needed as well.

* Remove `Capfile`, `Gemfile`, and `Gemfile.lock`
* Remove `config/deploy.rb`
* Remove `config/deploy/` directory

### wp-cron

Bedrock disables the internal WP Cron via `define('DISABLE_WP_CRON', true);`. If you keep this setting, you'll need to manually set a cron job like the following in your crontab file:

`*/5 * * * * curl http://example.com/wp/wp-cron.php`

## Todo

* Add Vagrant
* Solution for basic database syncing/copying

## Contributing

Everyone is welcome to help [contribute](CONTRIBUTING.md) and improve this project. There are several ways you can contribute:

* Reporting issues (please read [issue guidelines](https://github.com/necolas/issue-guidelines))
* Suggesting new features
* Writing or refactoring code
* Fixing [issues](https://github.com/roots/bedrock/issues)
* Replying to questions on the [forum](http://discourse.roots.io/)

## Support

Use the [Roots Discourse](http://discourse.roots.io/) forum to ask questions and get support.

[![Analytics](https://ga-beacon.appspot.com/UA-71591-43/bedrock/readme?pixel)](https://github.com/igrigorik/ga-beacon)
