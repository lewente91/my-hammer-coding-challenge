SHELL=/bin/bash

include .env

D = docker
DC = docker-compose
CONFIG = docker-compose.yaml
CONFIG_TEST = docker-compose.test.yaml
REPORTS_DIR = reports

.PHONY: help up up-build vendor stop prune prune-volume ps migrate seed test-build test-build-vendor test-phpunit test-prune

help: ## This help
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

.DEFAULT_GOAL := help

up: ## Start project specific web and PHP containers
	@${DC} -p ${APP_NAME} -f ${CONFIG} up -d; \

up-build: ## Start and build project specific web and PHP containers
	@${DC} -p ${APP_NAME} -f ${CONFIG} up -d --build; \

vendor: ## Composer install in the php container
	@${D} exec ${APP_NAME}_php composer install -n; \

stop: ## Stop project specific containers
	@${DC} -p ${APP_NAME} -f ${CONFIG} down; \

prune: ## Stop and remove project specific containers
	@${DC} -p ${APP_NAME} -f ${CONFIG} down --rmi local --remove-orphans; \

prune-volume: ## Stop and remove project specific containers and volumes
	@${DC} -p ${APP_NAME} -f ${CONFIG} down --rmi local --remove-orphans -v; \

ps: ## List project specific containers
	@${D} ps -f name=${APP_NAME} --format "table {{.ID}}\t{{.Names}}\t{{.Ports}}\t{{.RunningFor}}\t{{.Status}}"; \

migrate: ## Run database migrations
	@${D} exec ${APP_NAME}_php php bin/console doctrine:migrations:migrate -q; \

seed: ## Create test data
	@${D} exec ${APP_NAME}_php php bin/console doctrine:fixtures:load -q; \

test-build: ## Build and start test container, create report directories
	@${DC} -p ${APP_NAME} -f ${CONFIG_TEST} up -d --build; \
	mkdir -p ${REPORTS_DIR}/coverage/html; \

test-build-vendor: ## Composer install in the test container, works only with SSH keys having no password
	@${D} exec ${APP_NAME}_test composer install -n; \

test-phpunit: ## Run PHPUnit tests
	@${D} exec ${APP_NAME}_test ./vendor/bin/phpunit \
		--configuration ./phpunit.xml \
		--coverage-clover ./${REPORTS_DIR}/coverage/clover.xml \
		--coverage-crap4j ./${REPORTS_DIR}/coverage/crap4j.xml \
		--coverage-html ./${REPORTS_DIR}/coverage/html/ \
		./tests; \

test-prune: ## Remove test container
	@${D} stop ${APP_NAME}_test; \
	${D} rm ${APP_NAME}_test; \
