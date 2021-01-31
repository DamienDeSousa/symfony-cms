MAKE=make

help:
	echo TODO

up:
	docker-compose up -d

down:
	docker-compose down

install:
	docker-compose up -d
	composer install --ignore-platform-reqs
	$(MAKE) connection-php-container
	$(MAKE) migration-migrate

migration-migrate:
	php bin/console doctrine:database:create  
	php bin/console doctrine:migrations:migrate 

cache-clean:
	$(MAKE) connection-php-container
	php bin/console cache:clean

run-tests:
	$(MAKE) connection-php-container
	./bin/phpunit

connection-php-container:
	docker exec -it symfony-cms_php73_1 bash