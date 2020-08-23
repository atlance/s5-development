.PHONY: .env
.env:
	[ -f .env ] || cp .env.dist .env
	[ -f app/.env ] || cp app/.env.dist app/.env

include .env
export

up: docker-up ready
down: unready docker-down
down-clear: unready docker-down-clear clear-tmp
restart: unready docker-down docker-up ready
init: docker-down-clear docker-pull docker-build docker-up app-init ready up-supervisor git-hook

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down

docker-down-clear:
	docker-compose down -v --remove-orphans

docker-pull:
	docker-compose pull

docker-build:
	docker-compose build

ready:
	docker run --rm -v ${PWD}:${DOCKER_PROJECT_DIR} --workdir=${DOCKER_PROJECT_DIR} alpine touch .ready

unready:
	docker run --rm -v ${PWD}:${DOCKER_PROJECT_DIR} --workdir=${DOCKER_PROJECT_DIR} alpine rm -f .ready

up-supervisor:
	docker-compose run --rm -d php-fpm supervisord -c /etc/supervisor/supervisord.conf

app-init:
	docker-compose run --rm node yarn install
	docker-compose run --rm node npm rebuild node-sass
	docker-compose run --rm php-fpm composer install
	docker-compose run --rm php-fpm bin/console doctrine:migration:migrate --no-interaction
	docker-compose run --rm php-fpm composer phpstan
	docker-compose run --rm php-fpm bin/phpunit

git-hook:
	cp pre-commit .git/hooks/pre-commit
	chmod 777 .git/hooks/pre-commit

clear-tmp:
	rm -rf app/var/cache/*
	rm -rf app/var/log/*
	rm -rf app/var/run/*

php-bash:
	docker-compose run php-fpm bash
