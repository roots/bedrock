# [Bedrock](http://roots.io/wordpress-stack/)

Bedrock is a modern WordPress stack that helps you get started with the best development tools and project structure.

Bedrock's main features:

* Dependency management with [Composer](http://getcomposer.org)
* Automated deployments with [Capistrano](http://www.capistranorb.com/)
* Easy development environments with [Vagrant](http://www.vagrantup.com/) - coming soon!
* Better folder structure
* Easy WordPress configuration with environment specific files

Bedrock is meant as a base for you to fork and modify to fit your needs. It is delete-key friendly and you can strip out or modify any part of it. You'll also want to customize Bedrock with settings specific to your sites/company.

Note: While this is a project from the guys behind the [Roots starter theme](http://roots.io/starter-theme), Bedrock isn't tied to Roots in any way and works with any theme.

## Requirements

* Git
* PHP >= 5.3.2 (for Composer)
* Ruby >= 1.9 (for Capistrano)
* [VirtualBox](http://www.virtualbox.org/) >= 4.3.4
* Vagrant >= 1.4.0

If you aren't interested in using a part, then you don't need it's requirements either. Not deploying with Capistrano? Then don't worry about Ruby for example.

## Installation/Usage

1. Clone/Fork repo
2. Run `composer install`
3. Copy `.env.example` to `.env` and update environment variables:
  * `WP_ENV` - Set to environment (`development`, `staging`, `production`, etc)
  * `DB_NAME` - Database name
  * `DB_USER` - Database user
  * `DB_PASSWORD` - Database password
  * `DB_HOST` - Database host (defaults to `localhost`)
  * `WP_SITEURL` - Full URL to WordPress including subdirectory (http://example.com/wp)
  * `WP_HOME` - Full URL to WordPress home (http://example.com)
4. Add theme(s)
5. Access WP Admin at `http://<host>/wp/wp-admin`

## Todo

* Add Vagrant

## Documentation

### Folder Structure

### Configuration Files

### Environment Variables

### Composer

### Capistrano

## Contributing

Everyone is welcome to help [contribute](CONTRIBUTING.md) and improve this project. There are several ways you can contribute:

* Reporting issues (please read [issue guidelines](https://github.com/necolas/issue-guidelines))
* Suggesting new features
* Writing or refactoring code
* Fixing [issues](https://github.com/roots/bedrock/issues)
* Replying to questions on the [forum](http://discourse.roots.io/)

## Support

Use the [Roots Discourse](http://discourse.roots.io/) forum to ask questions and get support.
