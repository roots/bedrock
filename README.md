# Giant Hat Bedrock and Vagrant for Wordpress development
=======

This is the master repo for setting up a new Wordpress site locally.

## Prerequisites

You must have the following installed on your Mac OS X system in order to use this repository:

* Composer - [installation](https://getcomposer.org/doc/00-intro.md#globally-on-osx-via-homebrew-)
* Vagrant - [installation](https://docs.vagrantup.com/v2/installation/)
* Vagrant Triggers plugin - `vagrant plugin install vagrant-triggers`
* Ansible - [installation](http://docs.ansible.com/intro_installation.html)
* Virtualbox - [docs](https://www.virtualbox.org/)
* Git - derp of course
* Node/NPM
* Bower

## Quick Start Guide
=======

Setting up a new WP site with this repo as a starting point:

1. Clone this repo `git clone git@github.com:gianthat/bedrock.git yourprojectname`
2. Delete the project's .git folder with `rm -rf thisprojectfoldername`
3. Add new git remote for wherever your git repo is hosted `git remote add origin git@github.com:gianthat/yourprojectname.git`
4. Edit `yourprojectname/provisioning/hosts` file and change the `ansible_ssh_host` and `application_name` settings. The ssh host should ideally be a local IP address that doesn't match any other local IP's in use on your system (in `/etc/hosts` folder). Should be something like 192.168.33.##. Since others may be working on this repo as well, there may be conflicts with what other devs have setup locally so this may need to change once others are involved.
5. Go to the `yourprojectname/Vagrantfile` and set the IP address to the same address used above.
6. Edit your local `/etc/hosts` file and add a line for `192.168.33.## yourprojectname.dev`
7. Copy `.env.example` to `.env` and change DB_NAME and WP_HOME to match your project.
8. Install Ruby gems for Capistrano deployment with `bundle install` (we've already done a `cap install` so all the files are there)
9. Update `config/deploy.rb`, `config/deploy/staging.rb`, and `config/deploy/production.rb` to suit.
10. Go to `web/app/themes` folder and download theme from https://github.com/roots/sage
11. Rename folder from `sage` to yourprojectname.
12. Go to `web/app/themes/yourprojectname/assets/manifest.json` folder and set the *devURL* parameter to `http://yourprojectname.dev`
13. Edit the style.css file and change the theme name and other details to suit your project
14. Make sure you are in web/app/themes/yourprojectname/` and install npm modules `npm install`.
15. Install bower components `bower install --save`.
16. Go to the theme folder `.gitignore` file and delete the line with `dist` in it.
17. Now read sections below on running Composer, Vagrant, Gulp, and PHPMyAdmin.

### Composer

From the project root (not theme root), you need to run `composer install` locally (not in the vagrant shell). Your PHP version must be at least 5.4.

After initial setup you'll periodically use Composer to add plugins and update the version of Wordpress core.

To add a new plugin from Wordpress's wpackagist repo, use `composer require wpackagist-plugin/plugin-slug-here`.

To remove a plugin from this project, use `composer remove wpackagist-plugin/plugin-slug-here`.

### Vagrant

The base box has been set up with only basic libraries. We're using Ansible to provision it with other requirements on `vagrant up` which will allow for some flexibility.

```
# One-time only
$ vagrant box add ubuntu/trusty64

# Later if there are updates to the box
$ vagrant box outdated # check to make sure
$ vagrant box update # update it - this will take a long time

# Each time you want to spin it up
$ vagrant up # this will also provision if first time

# ssh into it
$ vagrant ssh

# Suspend it
$ vagrant halt

# Provision it (after it's "up"). If you make changes to the Ansible playbook, Ansible will run tasks that haven't been run before and ignore tasks that are already done.
$ vagrant provision

# Kill it
$ vagrant destroy # doing this will cause all of the Ansible provisioning tasks to run again next time you vagrant up.

```

### Gulp

In your theme folder, run `gulp build` (locally) the first time you set this up. Thereafter, when you are actively working on the theme, run `gulp watch` (locally) which will watch for file changes and recompile assets into the `dist` folder. It also spins up the site at localhost:3000 and updates CSS there automatically. To stop gulp from watching, hit `Ctrl+C`.

### PHPMyAdmin

You should be able to login at http://192.168.33.##/phpmyadmin (or http://yourprojectname.dev/phpmyadmin with the following credentials:

Username: wp_db_u
Password: password

Provided you have pulled and replaced your SQL dump, vagrant's provisioning should have sourced your databases. If you want to source a database outside of the normal startup procedure, use PHPMyAdmin or use the commands below (substituting the appropriate database name and folder name, of course):

```
$ vagrant ssh

$ mysql -u wp_db_u -ppassword

mysql> use projectname_dev;

mysql> source /var/www/web/mysqldumps/output.sql

OR

$ mysql -u wp_db_u -ppassword projectname_dev < /var/www/web/mysqldumps/output.sql
```
