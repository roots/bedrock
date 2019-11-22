[![CircleCI](https://circleci.com/gh/GSA/datagov-wp-boilerplate.svg?style=svg)](https://circleci.com/gh/GSA/datagov-wp-boilerplate)

# [Datagov-wp-boilerplate]

WordPress boilerplate based on [Bedrock](https://github.com/roots/bedrock)

Bedrock is a modern WordPress stack that helps you get started with the best development tools and project structure.

Much of the philosophy behind Bedrock is inspired by the [Twelve-Factor App](http://12factor.net/) methodology including the [WordPress specific version](https://roots.io/twelve-factor-wordpress/).

## Updating WP and plugin versions

Updating your WordPress version (or any plugin) is just a matter of changing the version number in the `composer.json` file.

Then running `composer update` will pull down the new version.

## Community

Most of Data.gov discussions happen at [Data.gov github](https://github.com/gsa/data.gov/issues)


## Development

### Prerequisites

- [Docker](https://docs.docker.com/install/) v18+
- [Docker Compose](https://docs.docker.com/compose/) v1.24+

### Setup

Build the docker containers.

    $ docker-compose build

Run the docker containers.

    $ docker-compose up

Install composer dependencies.

    $ docker-compose exec app composer install

Activate all the installed plugins and theme.

    $ docker-compose exec app wp core install --url=http://localhost:8000 \
      --title=Data.gov --admin_user=admin --admin_email=admin@example.com --allow-root
    $ docker-compose exec app wp plugin activate --all --allow-root
    $ docker-compose exec app wp theme activate roots-nextdatagov --allow-root

Open your browser to [localhost:8000](http://localhost:8000/).

_TODO: initialize the database with seed data so the theme loads properly._

### Restoring database dumps

You don't need a database dump for most development tasks. If you need
a database dump, you can create one following instructions from the
[Runbook](https://github.com/GSA/datagov-deploy/wiki/Runbook#database-dump).

Once you have the database dump, you can restore it for your local development
environment.

    $ docker-compose exec -T db mysql -u root -pmysql-dev-password datagov \
      < <(gzip --to-stdout --decompress databasedump.sql.gz)

## Admin dashboard

In order to access the admin dashboard for development, you must first disable
saml and update the admin password.

First, deactivate the saml plugin.

    $ docker-compose exec app wp --allow-root plugin deactivate saml-20-single-sign-on

Reset the admin password to `password`.

    $ docker-compose run --rm app wp --allow-root user update admin --user_pass=password

Open the login page
[localhost:8000/wp/wp-login.php](http://localhost:8000/wp/wp-login.php). Login
with the user `admin` password `password`.
