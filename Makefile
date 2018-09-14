SHELL=/bin/bash

include .env

D = docker
DC = docker-compose
CONFIG = docker-compose.yaml
REPORTS_DIR = reports

.PHONY: help up up-build vendor stop prune prune-volume ps

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
