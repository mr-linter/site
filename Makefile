serve:
	php artisan serve

docker-build:
	DOCKER_BUILDKIT=0 docker build -t ghcr.io/mr-linter/site-backend .

docker-run:
	docker-compose up

docker-push:
	@echo "${TOKEN}" | docker login ghcr.io -u ${USER} --password-stdin
	docker push ghcr.io/mr-linter/site-backend

update-linter:
	composer update artarts36/merge-request-linter -W
