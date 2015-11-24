# Ocasta Wordpress Template Project
Based on [Bedrock](https://github.com/roots/bedrock), but structured to work with Docker, and the Ocasta  [docker-nginx-hhvm-4wp](https://hub.docker.com/r/ocasta/docker-nginx-hhvm-4wp) Docker image.

To use this on your own project:

1. [Download this repository as a zip](https://github.com/ocastastudios/docker-nginx-hhvm-4wp/archive/master.zip)

2. Change occurrences of `PROJECT NAME` and `projectname` in this README

3. Change the name of the database in the `dev-env` file, making sure it matches the command in step 6 below

4. Continue the step below!

## Getting your development environment setup for the first time

1. Install [Docker Toolbox](https://www.docker.com/docker-toolbox)

2. Start the Docker Quickstart Terminal App and `cd` into the project folder

3. Login to [Docker Hub](https://hub.docker.com/)

    `docker login`

4. Start the docker containers for PROJECT NAME:

    `docker-compose up`

5. Install the dependencies using Composer: (See Composer notes and Docker commands below)

    `docker exec -it projectname_wp_1 bash -c 'cd /var/www/public_html; composer install'`

6. Setup a development database:

    `docker exec -it projectname_mariadb_1 mysql -e 'create database projectname_db'`

7. Import data (if there is any)

    `docker exec -i projectname_mariadb_1 mysql projectname_db < data/projectname_db.sql`

8. Add an entry to your `/etc/hosts` file:

    `192.168.99.100 docker.local`

9. Visit [docker.local](http://docker.local/) in your browser!

## Other Notes

The `docker-compose.yml` file in this project is intended for development environments only. 

### Composer

All Wordpress plugins are maintained through [Composer](https://getcomposer.org). You can optionally install this on your machine to run shorter commands after updating your `composer.json` file, or just the one built into the `wp` image like in step 4 above.   

To install via Homebrew

    brew install php/composer

then install the plugins

    composer install

Just want to **update** or you've made a change to composer.json

    composer update
or

    docker exec -it projectname_wp_1 bash -c 'cd /var/www/public_html; composer update'

### Passing WP Variables

Bedrock uses PhpDotEnv and reads WP Environment variables fro the file .env in the public_html folder.
In development we have a dev-env file that is mounted to public_html/.env in the docker-compose.yml

The same mechanism can be used to specify deployment specific values in a live environment.

The only thing to watch here is that the Bedrock DB_NAME will clash with a docker-compose generate environment
variable if the Database container is called **db**. So don't call it that!

### Debugging

- HHVM Output appears on stdout if the container is not running in daemon mode.
- The hhvm/php.ini override sets debug level to Verbose to view all compiler error and warning messages
- The hhvm/server.ini override enables xdebug. If you want to use xdebug you
will have to set xdebug.remote_host to your machines IP address.

### Useful Docker commands

Show running containers:

	docker ps

Show all containers:

	docker ps -a

Stop running containers:

	docker-compose stop

### Some not so useful Docker commands

Delete all containers:

  docker ps -a -q | xargs -n 1 -I {}  docker rm {}

Delete all un-tagged (or intermediate) images:

  docker rmi $( docker images | grep '<none>' | tr -s ' ' | cut -d ' ' -f 3)
