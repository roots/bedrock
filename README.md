## Requirements

* PHP >= 7.4
* Composer - [Install](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)

## Installation

* Clone the git repo - `git clone https://github.com/agencewonderful/monrepo`
* Import a given mysql dump of the database
* Import the `web/app/languages` folder. (Folder or location should be given to you)
* Import the `web/app/uploads` folder. (Folder or location should be given to you)
* Run `composer install`
* Copy `.env.example` to `.env` and update environment variables:
    * `DB_NAME` - Database name
    * `DB_USER` - Database user
    * `DB_PASSWORD` - Database password
    * `DB_HOST` - Database host
    * `WP_ENV` - Set to environment (`development`, `staging`, `production`)
    * `WP_HOME` - Full URL to WordPress home (http://example.com)
    * `WP_SITEURL` - Full URL to WordPress including subdirectory (http://example.com/wp)
    * `AUTH_KEY`, `SECURE_AUTH_KEY`, `LOGGED_IN_KEY`, `NONCE_KEY`, `AUTH_SALT`, `SECURE_AUTH_SALT`, `LOGGED_IN_SALT`, `NONCE_SALT` - Generate with [wp-cli-dotenv-command](https://github.com/aaemnnosttv/wp-cli-dotenv-command) or from the [Roots WordPress Salt Generator](https://roots.io/salts.html)
* Set your site vhost document root to `/path/to/site/web/`
* Run `npm install`
* Run `npm run sprites` Once upon first install, then once every time you add an icon to the svg folder
* Run `npm run build` to build once.
* run `npm run watch` to launch the watcher
* Access WP admin at `http://example.com/wp/wp-admin`
