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
	docker exec symfony-cms_php73_1 php bin/console doctrine:database:create --if-not-exists
	docker exec symfony-cms_php73_1 php bin/console doctrine:database:create --if-not-exists --env=test
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
	docker exec symfony-cms_php73_1 php bin/console assets:install /var/www/public/

migration-migrate: ## run migrations
	docker exec symfony-cms_php73_1 php bin/console doctrine:migrations:migrate --no-interaction

cache-clear: ## clear cache
	docker exec symfony-cms_php73_1 php bin/console cache:clear

run-tests: ## run automated tests, specify the PATH_TEST argument to run specific tests 
	docker exec symfony-cms_php73_1 php bin/console cache:clear --env=test
	docker exec symfony-cms_php73_1 php bin/console doctrine:migrations:migrate --no-interaction --env=test
	docker exec symfony-cms_php73_1 ./bin/phpunit $$PATH_TEST

#Tests are splited because there is a chromium issue when running too mush tests in the same time.
run-all-tests: ## run all automated tests
	docker exec symfony-cms_php73_1 php bin/console cache:clear --env=test
	docker exec symfony-cms_php73_1 php bin/console doctrine:migrations:migrate --no-interaction --env=test
	docker exec symfony-cms_php73_1 ./bin/phpunit tests/Command
#	docker exec symfony-cms_php73_1 ./bin/phpunit tests/Controller/Admin/BlockType
#	docker exec symfony-cms_php73_1 ./bin/phpunit tests/Controller/Admin/PageTemplate
	docker exec symfony-cms_php73_1 ./bin/phpunit tests/Controller/Admin/Security
	docker exec symfony-cms_php73_1 ./bin/phpunit tests/Controller/Admin/Site
#	docker exec symfony-cms_php73_1 ./bin/phpunit tests/Controller/Admin/PageTemplateBlockType

connection-php-container: ## connect to php container
	docker exec -it symfony-cms_php73_1 bash

connection-db-container: ## connect to database
	docker exec -it symfony-cms_mysql_1 mysql -uroot -proot symfony_cms

connection-node-container: ## connect to node
	docker exec -it symfony-cms_node_1 bash

composer-install: ## composer install
	docker-compose run composer-installer composer install

fix-permission: ## fix permission on project files
	sudo chown ${CURRENT_UID}:${CURRENT_GID} -R .
	docker exec -it symfony-cms_php73_1 chown www-data:www-data -R public/uploads

setup-public-directory: ## create icon directory not exists
	@mkdir -p app/public/uploads/icon/

composer-update: ## composer update
	docker-compose run composer-installer composer update
	docker-compose run composer-installer ./bin/phpunit

yarn-update: ## yarn update
	docker exec -it symfony-cms_node_1 yarn upgrade

expose-js-routes: ## expose symfony routes to js
	docker exec symfony-cms_php73_1 php bin/console fos:js-routing:dump --format=json --target=public/js/fos_js_routes.json
	docker exec -it symfony-cms_node_1 yarn encore dev

install-phpunit: ## install phpunit
	docker-compose run composer-installer ./bin/phpunit

ps: ## ps docker-compose services
	docker-compose ps

migration-diff: ## generate a migration by comparing your current database to your mapping information
	docker-compose exec php73 php bin/console doctrine:migrations:diff