#!make

user := $(shell id -u)
group := $(shell id -g)
dc := USER_ID=$(user) GROUP_ID=$(group) docker-compose
de := docker-compose exec
sy := $(de) php bin/console
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
	## haikel


##
###----------------------#
###    Composer 🧙‍
###----------------------#
##
install: composer.lock ## Install vendor
	sudo $(dc)  exec -u root php composer install
update: composer.lock ## Install vendor
	sudo $(dc)  exec -u root php  composer update
autoload: ## autoload Composer
	sudo $(dc)  exec -u root php composer dump-autoload

##
###----------------------#
###    Symfony 🎵
###----------------------#
##
cc: up      ##  cache clear
	$(sy) cac:c
assets:up	##  Install the assets with symlinks in the public folder
	$(sy) assets:install
migration: up ##  Migration
	$(sy) make:migration
migrate: up   ##  Migrate
	sudo $(dc) exec -u www-data php php bin/console doctrine:migrations:migrate
fix-perms: ##error
	$(de) php chmod 777 -R var/
##
###----------------------#
###    Docker 🐳
###----------------------#
##
up: ## Start the docker hub
	$(dc) up -d
down: ## Stop the docker hub
	$(dc) down
build: ## build the docker hub
	$(dc) build
.PHONY: logs
logs: 	##  look for 's' service logs, make s=php logs
	$(dc) logs -f $(s)
##
###----------------------#
###    Project 🐝
###----------------------#
##
db: up  ##  Create Database
	$(sy) doctrine:database:create
fixtures: up  ##  Build the DB, control the schema validity, load fixtures and check the migration status
	$(sy) doctrine:fixtures:load
entity: up  ##  Create Entity in ure Domaine
	$(sy) next:entity
data: up ## add new data
	$(sy) next:data
routingjs: ## Generate routing json
	$(sy)  fos:js-routing:dump --format=json --target=public/js/fos_js_routes.json
##
###----------------------#
###  Coding standards ✨
###----------------------#
##
phpcs: up  ## executes coding standards
	$(de) php ./vendor/bin/php-cs-fixer fix --using-cache=no
	$(de) php ./vendor/bin/phpcs src/
phpstan: ## executes php analizers
	$(de) php ./vendor/bin/phpstan analyse src/
phpmd: ## executes coding standards in dry run mode PHP Mess Detector applique certaines règles pour vérifier la qualité
	$(de) php ./vendor/bin/phpmd src/ text phpmd.xml
.PHONY: psalm
psalm: ## execute psalm analyzer
	$(de) php  ./vendor/bin/psalm --show-info=false

##
###---------------------------#
###    Yarn 🐱 / JavaScript
###---------------------------#
##

encore-dev: up   ##  encore dev
	$(de)  php yarn encore dev
encore-prod: up  ##  encore prod
	$(de) php yarn encore production
encore-watch: up  ##  encore watch
	$(de) php yarn encore dev --watch
js-install: ##  install JavaScript dependencies
	$(de) php yarn install
js-upgrade: ##  upgrade JavaScript dependencies
	$(de) php yarn upgrade
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
