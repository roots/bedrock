# Efeqdev Bedrock and Vagrant for Wordpress development

====

This is the master repo for setting up a new Wordpress site locally.

## Prerequisites

You must have the following installed on your Mac OS X system in order to use this repository:

* Composer - [installation](https://getcomposer.org/doc/00-intro.md#globally-on-osx-via-homebrew-)
* Vagrant - [installation](https://docs.vagrantup.com/v2/installation/)
* Vagrant Triggers plugin - `vagrant plugin install vagrant-triggers`
* Ansible - [installation](http://docs.ansible.com/intro_installation.html)
* Grunt - [installation](http://gruntjs.com/getting-started)
* Virtualbox - [docs](https://www.virtualbox.org/)
* Git - derp of course

## Quick Start Guide

Before getting started, make sure you have the prerequisites listed above installed.

Setting this project up for the first time: 

1. Be sure the hosts record for your project has been added to the efeqdev/bedrock repository hosts file. See instructions [here](https://docs.google.com/a/efeqdev.com/document/d/162i2Yc_XLP5eFkvawyhS0_v8kBL42l50ljVzMEYZuIo/edit?usp=sharing) if you are setting up a brand new project.
2. Download this repository: `git clone git@github.com:efeqdev/bedrock.git`
3. Change remote origin: `git remote rm origin && git remote add origin <github url of this site's repo>`
4. If there is not a line in the hosts file for this project, add one. Also, add the line to the main efeqdev/bedrock repository and commit/push change.
5. Install Grunt dependencies: `npm install`
6. Sync hosts files: `sudo /your/local/path/to/this/folder/hosts.sh`
7. Update variables in secret.json file.
8. If this is not a brand new project, pull database dump from production server: `grunt process_dumps`. Otherwise, skip this step.
9. Install packages: `composer install`
10. Add the Vagrant box: `vagrant box add efeqdev/wp-ubuntu-14.04`
11. Update /provisioning/hosts file with the correct application_name variable
12. Start Vagrant and provision the box: `vagrant up`. When asked if you want to source the database, answer 'y' if you did Step 7.
13. Check out http://yourprojectname.dev to confirm the site is up.
14. Log in to PHPMyAdmin at http://192.168.33.10/phpmyadmin (Username: wp_db_u Password: password)

See Commands section for more detailed explanation of available tasks.

## Commands

**Note:** All commands below assume you are cd'd into this directory.

### Syncing Hosts file

**Note:** If this project was previously worked on and you have an /etc/hosts file record for 127.0.0.1 yourprojectname.dev, remove that line before continuing.

In your local terminal, run:

`$ sudo /your/local/path/to/this/folder/hosts.sh`

This will replace the lines in your /etc/hosts file and make a backup at /etc/hosts.backup.

The IP address of 192.168.33.10 is in the protected range for private networking.

**Note:** the hosts file contained in this directory has a comment `# Main Wordpress Cluster` that is used to ensure the process doesn't duplicate lines. So in that sense it is brittle and will break if you remove that comment from the file or put anything above it.

### Pulling database dumps and unzipping / Search and Replace database dumps

Database dumps on the remote server are made nightly at 11:55pm and live in /tmp/mysqldumps on the remote server. If this is a new project and there is no database on the remote server yet, skip this step.

In your local terminal, run these commands:

```
# PULL AND PREP FOR DEVELOPMENT - does not source the database, that happens in the vagrant provisioning playbook - so do this before vagrant up
# To pull dump, unzip, and search and replace domains
$ grunt db_to_dev

# To pull file only
$ grunt exec:get_prod_dump

# To unzip only
$ grunt exec:unzip_prod # This will overwrite existing .sql files.

# PREP DUMPS FOR OTHER DIRECTIONALS - dev to prod, staging to dev, etc.
# We've started building out these functions, but the system is not complete
$ grunt db_to_prod # requires a manually dumped db file at web/mysqldumps/latest_to_prod.sql
$ grunt db_to_staging # requires a manually dumped db file at web/mysqldumps/latest_to_staging.sql
$ grunt db_staging_to_dev # in case you are in need of the staging database and have grabbed a dump from the server - requires this file to be at web/mysqldumps/latest_staging_to_dev.sql.gz
```

### Syncing uploads directory

```
# To pull all uploads
$ grunt get_uploads

# Or to sync - probably better and faster
$ grunt sync_uploads

```

### Vagrant

The base box has been set up with only basic libraries. We're using Ansible to provision it with other requirements on `vagrant up` which will allow for some flexibility.

```
# One-time only
$ vagrant box add efeqdev/wp-ubuntu-14.04

# Later if there are updates to the box
$ vagrant box outdated # check to make sure
$ vagrant box update # update it - this will take a long time

# Each time you want to spin it up
$ vagrant up # this will also provision

# ssh into it
$ vagrant ssh

# Suspend it
$ vagrant halt

# Provision it (after it's "up"). If you make changes to the Ansible playbook, Ansible will run tasks that haven't been run before and ignore tasks that are already done.
$ vagrant provision

# Kill it
$ vagrant destroy # doing this will cause all of the Ansible provisioning tasks to run again next time you vagrant up.

```

### PHPMyAdmin

You should be able to login at http://192.168.33.10/phpmyadmin with the following credentials:

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

## TODO

Must do:
* Pull/merge production uploads directory

Nice to have:
* Make hosts bash script into Grunt task instead.
* Disable caching plugins in database?


## Information about this projects core architecture

efeqdev/bedrock is built off of [Bedrock](http://roots.io/wordpress-stack/), a modern WordPress stack that helps you get started with the best development tools and project structure. View the [github repo readme](https://github.com/roots/bedrock/blob/master/README.md) to learn more about that.


