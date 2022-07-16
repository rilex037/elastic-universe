APP_CONTAINER=docker-compose exec php sh -c

dockerize:
	@echo "Installing and starting project..."
	@docker-compose down
	@docker network inspect test-net >/dev/null 2>&1 || docker network create --driver bridge test-net
	@cp .env.example .env
	@docker-compose up -d --build
	@$(APP_CONTAINER) "composer install --no-interaction;"
	@sleep 10 && $(APP_CONTAINER) "php artisan es:create_mappings;"

start-up:
	@docker-compose down
	@docker network inspect test-net >/dev/null 2>&1 || docker network create --driver bridge test-net
	@docker-compose up -d

# make test ARGS="tests/Feature/Endpoints/Graphql/TodoCreateTest.php"
test:
	@$(APP_CONTAINER) "php artisan test $(ARGS)"

generate-coverage:
	@$(APP_CONTAINER) "php -dxdebug.mode=coverage ./vendor/phpunit/phpunit/phpunit --coverage-html ./storage/app/public/build/coverage-report --testsuite Feature,Unit --stop-on-failure; \
	chmod -R 777 .";

fix-permisions:
	@echo "Fixing file permissions..."
	@$(APP_CONTAINER)  "chmod -R 777 ."
	@echo "Done."