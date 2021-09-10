#!make
user := $(shell id -u)
group := $(shell id -g)
DOCKER_COMPOSE = docker-compose
EXEC = $(DOCKER_COMPOSE) exec
EXEC_PHP = $(DOCKER_COMPOSE) exec php
SYMFONY = $(EXEC_PHP) bin/console
COMPOSER = $(EXEC_PHP) composer
# define standard colors
BLACK        := $(shell tput -Txterm setaf 0)
RED          := $(shell tput -Txterm setaf 1)
GREEN        := $(shell tput -Txterm setaf 2)
YELLOW       := $(shell tput -Txterm setaf 3)
LIGHTPURPLE  := $(shell tput -Txterm setaf 4)
PURPLE       := $(shell tput -Txterm setaf 5)
BLUE         := $(shell tput -Txterm setaf 6)
WHITE        := $(shell tput -Txterm setaf 7)

RESET := $(shell tput -Txterm sgr0)

TARGET_COLOR := $(BLUE)
POUND = \#
.PHONY: no_targets__ info help build deploy doc
	no_targets__:
.DEFAULT_GOAL := help
colors:
	@echo "${BLACK}BLACK${RESET}"
	@echo "${RED}RED${RESET}"
	@echo "${GREEN}GREEN${RESET}"
	@echo "${YELLOW}YELLOW${RESET}"
	@echo "${LIGHTPURPLE}LIGHTPURPLE${RESET}"
	@echo "${PURPLE}PURPLE${RESET}"
	@echo "${BLUE}BLUE${RESET}"
	@echo "${WHITE}WHITE${RESET}"

##
## Project
## -------
##
build: ## build the project
	$(DOCKER_COMPOSE) build

kill: ## kill the project
	$(DOCKER_COMPOSE) kill

start: ## Start the project
	$(DOCKER_COMPOSE) up -d --remove-orphans --no-recreate

stop: ## Stop the project
	$(DOCKER_COMPOSE) stop

vendor: ## install composer
vendor: composer.lock
	$(COMPOSER) install

cc: start  ## cache clear
	$(SYMFONY)  c:c
##
## DB
## -------
##
database-test: ## create database  test
	$(SYMFONY) doctrine:database:drop --if-exists --force --env=test
	$(SYMFONY) doctrine:database:create --env=test
	$(SYMFONY) doctrine:schema:update --force --env=test

database-dev: ## create database dev
	$(SYMFONY)  doctrine:database:drop --if-exists --force --env=dev
	$(SYMFONY)  doctrine:database:create --env=dev

fixtures-test: ## load fixtures test
fixtures-test:
	$(SYMFONY) doctrine:fixtures:load -n --env=test

fixtures-dev: ## load fixtures dev
fixtures-dev:
	$(SYMFONY) doctrine:fixtures:load -n --env=dev

migration: ## Generate a new doctrine migration a verfier
migration: vendor
	$(SYMFONY) make:migration

migrate: ## add new tables
migrate: vendor
	$(SYMFONY) doctrine:migrations:migrate

db-validate-schema: ## Validate the doctrine ORM mapping
db-validate-schema: vendor
	$(SYMFONY) doctrine:schema:validate

fixtures: start  ##  Build the DB, control the schema validity, load fixtures and check the migration status
	$(SYMFONY) doctrine:fixtures:load
##
## Quality assurance
## -----------------
##
ci: ## Run all quality insurance checks (tests, code styles, linting, security, static analysis...)
#ci: php-cs-fixer phpcs phpmd phpmnd phpstan psalm lint validate-composer validate-mapping security test test-coverage test-spec
ci: php-cs-fixer phpcs  phpstan  db-validate-schema security test test-coverage


phpcs: ## Run phpcode_sniffer
phpcs:
	$(EXEC_PHP) vendor/bin/phpcs

php-cs-fixer: ## Run PHP-CS-FIXER
php-cs-fixer:
	$(EXEC_PHP) vendor/bin/php-cs-fixer fix --verbose

phpstan: ## Run PHPSTAN
phpstan:
	$(EXEC_PHP) vendor/bin/phpstan analyse


security: ## Run security-checker
security:
	$(EXEC_PHP) symfony security:check --no-interaction

test: ## Run phpunit tests
test:
	$(EXEC_PHP) vendor/bin/phpunit

test-coverage-xdebug: ## Run phpunit tests with code coverage (xdebug - uncomment extension in dockerfile)
test-coverage-xdebug:
	$(EXEC_PHP) vendor/bin/phpunit --coverage-html=tools/coverage

validate-composer: ## Validate composer.json and composer.lock
validate-composer:
	$(EXEC_PHP) composer validate


##
###---------------------------#
###   🐝 The Next Symfony Makefile 🐝
###---------------------------#
##

.PHONY: help
help: ## Outputs this help screen
	@echo ""
	@echo "    ${BLACK}:: ${RED}Self-documenting Makefile${RESET} ${BLACK}::${RESET}"
	@echo ""
	@echo " ✔ Document targets by adding '$(POUND)$(POUND) comment' after the target  ✔ "
	@echo ""
	@echo "${BLACK}-----------------------------------------------------------------${RESET}"
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-20s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'
