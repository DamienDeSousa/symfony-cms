MAKE=make

SHELL := /bin/bash

CURRENT_UID := $(shell id -u)
CURRENT_GID := $(shell id -g)
CURRENT_PWD := $(shell pwd)

help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

up: ## start containers
	docker-compose up -d --build

down: ## stop containers
	docker-compose down

install: ## install CMS
	$(MAKE) up
	$(MAKE) composer-install
	$(MAKE) cache-clear
	docker-compose exec php-fpm php bin/console doctrine:database:create --if-not-exists
	docker-compose exec php-fpm php bin/console doctrine:database:create --if-not-exists --env=test
	$(MAKE) migration-migrate
	$(MAKE) setup-public-directory
	$(MAKE) asset-install
	$(MAKE) fix-permission

reset-workspace-from-develop: ## clean workspace before starting new development
	$(MAKE) down
	git reset --hard origin/develop
	git pull --rebase origin develop
	$(MAKE) up
	$(MAKE) composer-install
	$(MAKE) cache-clear
	$(MAKE) expose-js-routes
	$(MAKE) migration-migrate
	$(MAKE) setup-public-directory

asset-install: ## install asset
	docker-compose exec php-fpm php bin/console assets:install /var/www/public/

migration-migrate: ## run migrations
	docker-compose exec php-fpm php bin/console doctrine:migrations:migrate --no-interaction

cache-clear: ## clear cache
	docker-compose exec php-fpm php bin/console cache:clear

run-tests: ## run automated tests, specify the PATH_TEST argument to run specific tests 
	docker-compose exec php-fpm php bin/console cache:clear --env=test
	docker-compose exec php-fpm php bin/console doctrine:migrations:migrate --no-interaction --env=test
	$(MAKE) asset-install
	docker-compose exec php-fpm ./bin/phpunit $$PATH_TEST

#Tests are splited because there is a chromium issue when running too mush tests in the same time.
run-all-tests: ## run all automated tests
	docker-compose exec php-fpm php bin/console cache:clear --env=test
	docker-compose exec php-fpm php bin/console doctrine:migrations:migrate --no-interaction --env=test
	$(MAKE) asset-install
	docker-compose exec php-fpm ./bin/phpunit tests/Command
	docker-compose exec php-fpm ./bin/phpunit tests/Controller/Admin/BlockType
	docker-compose exec php-fpm ./bin/phpunit tests/Controller/Admin/PageTemplate
	docker-compose exec php-fpm ./bin/phpunit tests/Controller/Admin/Security
	docker-compose exec php-fpm ./bin/phpunit tests/Controller/Admin/Site
	docker-compose exec php-fpm ./bin/phpunit tests/Controller/Admin/PageTemplateBlockType

connection-php-container: ## connect to php container
	docker-compose exec php-fpm bash

connection-db-container: ## connect to database
	docker-compose exec mysql mysql -uroot -proot symfony_cms

connection-node-container: ## connect to node
	docker-compose exec node bash

composer-install: ## composer install
	docker-compose exec php-fpm composer install

fix-permission: ## fix permission on project files
	sudo chown ${CURRENT_UID}:${CURRENT_GID} -R .
	docker-compose exec php-fpm chown www-data:www-data -R public/uploads

setup-public-directory: ## create icon directory not exists
	@mkdir -p app/public/uploads/icon/

composer-update: ## composer update
	docker-compose exec php-fpm composer update
	docker-compose exec php-fpm ./bin/phpunit

yarn-update: ## yarn update
	docker-compose exec node yarn upgrade

expose-js-routes: ## expose symfony routes to js
	docker-compose exec php-fpm php bin/console fos:js-routing:dump --format=json --target=public/js/fos_js_routes.json
	docker-compose exec node yarn encore dev

install-phpunit: ## install phpunit
	docker-compose exec php-fpm ./bin/phpunit

ps: ## ps docker-compose services
	docker-compose ps

migration-diff: ## generate a migration by comparing your current database to your mapping information
	docker-compose exec php-fpm php bin/console doctrine:migrations:diff