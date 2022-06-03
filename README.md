# Project Installation

* PHP >= 8.0
* Composer - [Install](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)
* node >= 16

- This site is set to be run on PHP 8.0 and node 16.
- It requires composer. [Install](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)
- The technical environment prerequisites can be found on [this page](https://www.wonderwp.com.wdf-02.ovea.com/doc/DevOps/Server_Config.html#page_WDF-02)

## Access

- This project's files are hosted on a GitHub repository accessed here : **`[your_repo_url_here]`**
- You'll need read or write permissions to access the repository files. Ask Jeremy Desvaux or Marc Lafay for an access.
- Clone the git repo over ssh - **`git clone git@github.com:agencewonderful/yourproject.git`**
- A database dump is required, it can be downloaded from the staging or production environment, or should be given to you.
- Import the `web/app/languages` folder. (Folder or location should be given to you)
- Import the `web/app/uploads` folder. (Folder or location should be given to you)

## Configuration

Once the project has been installed, you'll need to go over the following steps :

* Imagine a local url for your website. (ex **`http://local.example.com`**)
* Create a virtual host in your development environment for this URL, then point its document root to the `web` folder
* Run `composer install`
* Copy `.env.example` to `.env` and update environment variables:
    * `DB_NAME` - Database name
    * `DB_USER` - Your development environment database user
    * `DB_PASSWORD` - Your development environment database password
    * `DB_HOST` - Your development environment database host
    * `WP_ENV` - Set to environment. Can be either `development`, or `staging`, or `production`.
    * `WP_HOME` - Full URL to WordPress home local url (**`http://local.example.com`**)
    * `WP_SITEURL` - Should be : `"${WP_HOME}/wp"`
    * `AUTH_KEY`, `SECURE_AUTH_KEY`, `LOGGED_IN_KEY`, `NONCE_KEY`, `AUTH_SALT`, `SECURE_AUTH_SALT`, `LOGGED_IN_SALT`, `NONCE_SALT` - Generate with [wp-cli-dotenv-command](https://github.com/aaemnnosttv/wp-cli-dotenv-command) or from the [Roots WordPress Salt Generator](https://roots.io/salts.html)
* Run `npm install`
* Run `npm run sprites` Once upon first install, then once every time you add an icon to the svg folder
* Run `npm run build` to build once, or run `npm run watch` to launch the watcher
* Additional commands can be available in the main `package.json` file.

## Run

Given your development environment is running:

- You can view this website by accessing its local url at **`http://example.com/`**.
- You can access the admin at **`http://example.com/wp/wp-admin`**

## Contribution

### GitFlow
We'll be running this project with the following GitFlow configuration :

- Production branch : `main`
- Staging branch : `develop`
- Feature branch prefix : `feature/`
- Release branch prefix : `release/`
- Hotfix branch prefix : `hotfix/`

### Branching process

- The `main` branch represents what's currently in **production**.
- The `develop`branch represents what's currently in **staging**.
- To propose a feature, open a GitFlow feature branch originating from develop. Ideally, create one feature branch per feature.
- No direct merge on develop nor main are allowed : pull requests are mandatory to merge a feature back to develop.
- Before opening a pull request : merge the develop branch on the feature branch and solve any eventual merge conflict.
- Once the code review is ready for merge : use the squash and merge strategy to merge the PR into the develop branch, then delete the feature branch.

### Commit conventions

Commits must follow the [conventional commits](https://www.conventionalcommits.org/en/v1.0.0/) convention.

#### TL;DR

The commit message should be structured as follows:

```
(app part/scope):

[optional body]

[optional footer(s)]
```

The commit contains the following structural elements, to communicate intent to the consumers of your library:

- **fix**: a commit of the type `fix` patches a bug in your codebase (this correlates with PATCH in Semantic Versioning).
- **feat**: a commit of the type `feat` introduces a new feature to the codebase (this correlates with MINOR in Semantic Versioning).
- **BREAKING CHANGE**: a commit that has a footer `BREAKING CHANGE`:, or appends a ! after the type/scope, introduces a breaking API change (correlating with MAJOR in Semantic Versioning). A BREAKING CHANGE can be part of commits of any type.
- _types_ other than `fix` and `feat` are allowed, for example @commitlint/config-conventional (based on the the Angular convention) recommends `build`, `chore`, `ci`, `docs`, `style`, `refactor`, `perf`, `test`, and others.
- _footers_ other than BREAKING CHANGE:  may be provided and follow a convention similar to git trailer format.


## Deployment

- Deployment is automated via a Jenkins CI pipeline
