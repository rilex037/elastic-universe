APP_CONTAINER=docker-compose exec -T php sh -c

dockerize:
	docker-compose down
	docker network create --driver bridge test-net || true
	docker-compose up -d --build
	$(APP_CONTAINER) "composer install --no-interaction;"

fix-permisions:
	sudo chown -R $$USER:$$USER . && \
	chmod -R 777 .