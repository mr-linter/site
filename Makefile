.PHONY: build
.DEFAULT_GOAL: help

# https://marmelab.com/blog/2016/02/29/auto-documented-makefile.html
help: ## Show this help
	@printf "\033[33m%s:\033[0m\n" 'Available commands'
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z0-9_-]+:.*?## / {printf "  \033[32m%-18s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

init: ## Init service
	cp .env.example .env
	docker-compose build mr-linter-backend
	docker-compose run --entrypoint "./artisan" mr-linter-backend key:generate
	make deps

build: ## Build docker image
	DOCKER_BUILDKIT=0 docker build -t ghcr.io/mr-linter/site-backend .

run: ## Run in docker
	DOCKER_BUILDKIT=0 docker-compose up

push: ## Push docker image to ghcr
	@echo "${TOKEN}" | docker login ghcr.io -u ${USER} --password-stdin
	docker push ghcr.io/mr-linter/site-backend

update-linter: ## Update linter version
	composer update artarts36/merge-request-linter -W

deps:
	docker-compose run --entrypoint "composer" mr-linter-backend install
