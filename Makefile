.PHONY: build install bash test

build:
	docker-compose up -d --build

install:
	docker exec -it bmtestfoucault-php composer install -d /var/www/bmtestfoucault/

bash:
	docker exec -it bmtestfoucault-php bash

test:
	docker exec -it bmtestfoucault-php vendor/bin/simple-phpunit
