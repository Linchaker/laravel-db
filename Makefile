#---------------------------------------------------------------
#-- CONFIG --
#---------------------------------------------------------------

PHP_CONTAINER=db_integration_phpfpm
MSSQL_CONTAINER=db_integration_mssql

#---------------------------------------------------------------
#-- DOCKER UP --
#---------------------------------------------------------------
up:
	docker-compose up -d

down:
	docker-compose down --remove-orphans

build:
	docker-compose up -d --build

#---------------------------------------------------------------
#-- PROJECT SETUP --
#---------------------------------------------------------------
composer-install:
	docker exec -it $(PHP_CONTAINER) composer install

migrate:
	docker exec -it $(PHP_CONTAINER) php artisan migrate

seed:
	docker exec -it $(PHP_CONTAINER) php artisan db:seed

first-init:
	make up
	make composer-install
	make migrate
	make seed

refresh:
	docker exec -it $(PHP_CONTAINER) php artisan migrate:fresh
	make seed

#---------------------------------------------------------------
#-- CONTAINERS --
#---------------------------------------------------------------
php:
	docker exec -it $(PHP_CONTAINER) bash

# inside container use cmd: /opt/mssql-tools/bin/sqlcmd -U sa
mssql:
	docker exec -it $(MSSQL_CONTAINER) bash

#---------------------------------------------------------------
#-- COMMANDS --
#---------------------------------------------------------------
clear:
	docker exec -it $(PHP_CONTAINER) php artisan optimize:clear

