.DEFAULT_GOAL := help
help:
	@grep -E '^[a-zA-Z-]+:.*?## .*$$' Makefile | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "[32m%-17s[0m %s\n", $$1, $$2}'
.PHONY: help

docker-php: ## Connect php
	@docker-compose exec php bash

docker-db: ## Connect db
	@docker-compose exec db bash

initialize: ## Initialize project
	@cp .env.dist .env
	@docker-compose up -d
	@docker-compose run php composer install
	@docker-compose run php bin/console d:m:m -e dev
	@docker-compose run php bin/console d:d:c -e test
	@docker-compose run php bin/console d:m:m -e test
