up:
	docker-compose up -d
build:
	docker-compose build
update:
	docker-compose run --rm app composer update
clean:
	docker-compose down -v
	rm -rf web/app/mu-plugins/*/ web/app/plugins/* web/app/uploads/* web/app/themes web/wp vendor

setup:
	sleep 15 #wait for the db to allow connections
	docker-compose exec app wp core download --allow-root
	docker-compose exec app wp core install --url=http://localhost:8000 --title=Data.gov --admin_user=admin --admin_email=admin@example.com --allow-root
	docker-compose exec app wp plugin activate --all --allow-root
	docker-compose exec app wp theme activate roots-nextdatagov --allow-root


.PHONY: clean
