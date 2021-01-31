MAKE=make

help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

up: ## start containers
	docker-compose up -d

down: ## stop containers
	docker-compose down

install: ## install CMS
	$(MAKE) up
	composer install --ignore-platform-reqs
	docker exec symfony-cms_php73_1 php bin/console doctrine:database:create
	$(MAKE) migration-migrate

migration-migrate: ## run migrations
	docker exec symfony-cms_php73_1 php bin/console doctrine:migrations:migrate --no-interaction

cache-clean: ## clean cache
	docker exec symfony-cms_php73_1 php bin/console cache:clear

run-tests: ## run automated tests 
	docker exec symfony-cms_php73_1 ./bin/phpunit

connection-php-container: ## connect to php container
	docker exec -it symfony-cms_php73_1 bash