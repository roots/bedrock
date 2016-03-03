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
4. Edit `provisioning/hosts` file and change the `ansible_ssh_host` and `application_name` settings. The ssh host should ideally be a local IP address that doesn't match any other local IP's in use on your system (in `/etc/hosts` folder). Should be something like 192.168.33.##. Since others may be working on this repo as well, there may be conflicts with what other devs have setup locally so this may need to change once others are involved.
5. Go to the `Vagrantfile` and set the IP address to the same address used above.
6. Edit your local `/etc/hosts` file and add a line for `192.168.33.## yourprojectname.dev`
7. Copy `.env.example` to `.env` and update environment variables.
8. Go to `web/app/themes` folder and download theme from https://github.com/roots/sage
9. Rename folder from `sage` to yourprojectname.
10. Go to `web/app/themes/yourprojectname/assets` folder and set the *devURL* parameter to `http://yourprojectname.dev`
11. Install npm modules `npm install`.
12. Install bower components `bower install --save`.
13. Go to the theme folder `.gitignore` file and delete the line with `dist` in it.
14. Now read sections below on running Vagrant, Gulp, and PHPMyAdmin.


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

In your theme folder, run `gulp build` one time. Thereafter, when you are actively working on the theme, run `gulp watch` which will watch for file changes and recompile assets into the `dist` folder. It also spins up the site at localhost:3000 and updates CSS there automatically. To stop gulp from watching, hit `Ctrl+C`.

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
