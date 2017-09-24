# Pixels Bedrock

Pixels Bedrock is a forked version of [roots/bedrock](https://github.com/roots/bedrock), a modern WordPress stack that helps you get started with the best development tools and project structure.

Much of the philosophy behind Bedrock is inspired by the [Twelve-Factor App](http://12factor.net/) methodology including the [WordPress specific version](https://roots.io/twelve-factor-wordpress/).

## Updates

Pixels Bedrock will be updated every 6 months, along the same timeline as the [Pixels Starter Theme](https://github.com/pixelshelsinki/pixels-starter-theme), merging in updates that have been made over the previous 6 months.

## Issues, improvements and these instructions.

Please read the documentation below before using. **If things are not clear or you find a mistake, or simply a way to improve the theme, please submit an issue or pull request.**

## Tools and Technologies

* Dependency management with [Composer](http://getcomposer.org)
* Easy WordPress configuration with environment specific files
* Environment variables with [Dotenv](https://github.com/vlucas/phpdotenv)
* Autoloader for mu-plugins (use regular plugins as mu-plugins)
* Enhanced security (separated web root and secure passwords with [wp-password-bcrypt](https://github.com/roots/wp-password-bcrypt))

## Requirements

* PHP >= 5.6
* Composer - [Install](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)

## Installation

These instructions should cover most installation instances, for full project setup instructions a project including using Local by Flywheel, see [here](https://public.3.basecamp.com/p/PQmrYKcbrnrKCYpKnEq7DSLV)

1. Download this repository as a ZIP (don't clone!).

2. Drop it into your `sites` or equivalent development folder, and rename to be the project name.

3. In Terminal run `composer install` in the root of this folder.

4. Create an `.env` file by duplicating `.env.example`.

   `cp .env.example .env`

5. Update the environment variables in the `.env` file:
  * `DB_NAME` - Database name
  * `DB_USER` - Database user
  * `DB_PASSWORD` - Database password
  * `DB_HOST` - Database host
  * `WP_ENV` - Set to environment (`development`, `staging`, `production`)
  * `WP_HOME` - Full URL to WordPress home (http://example.com)
  * `WP_SITEURL` - Full URL to WordPress including subdirectory (http://example.com/wp)
  * `AUTH_KEY`, `SECURE_AUTH_KEY`, `LOGGED_IN_KEY`, `NONCE_KEY`, `AUTH_SALT`, `SECURE_AUTH_SALT`, `LOGGED_IN_SALT`, `NONCE_SALT` using the [Roots WordPress Salt Generator][roots-wp-salt].

6. Add theme(s) in `web/app/themes` as you would for a normal WordPress site.

7. Set your site vhost document root to `/path/to/site/web/` (`/path/to/site/current/web/` if using deploys)

8. Access WP admin at `http://example.com/wp/wp-admin`

## Deploys

Pixels Bedrock sites are (ideally) deployed using Capistrano.

Deploy scripts are already in `config/deploy.rb`, project variables can be found in `config/config.rb` and environment deploy variables in `config/deploy/<environment>.rb`.

For deployment to servers that don't allow SSH connections etc, custom deployment scripts will need to be written.

## Documentation

Original Bedrock documentation is available at [https://roots.io/bedrock/docs/](https://roots.io/bedrock/docs/).
