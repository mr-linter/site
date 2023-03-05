serve:
	php artisan serve

docker-build:
	docker build . ghcr.io/mr-linter/site-backend

docker-run:
	docker-compose up

docker-push:
	@echo "${TOKEN}" | docker login ghcr.io -u ${USER} --password-stdin
	docker push ghcr.io/mr-linter/site-backend
