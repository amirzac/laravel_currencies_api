docker_php_fpm = sharpeo-php-fpm
docker_php_cli = sharpeo-php-cli
docker_node = sharpeo-node
docker_mysql = sharpeo-mysql
docker_nginx = sharpeo-nginx

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down

docker-build:
	docker-compose up --build -d

test:
	docker-compose exec php-cli vendor/bin/phpunit

connect-php:
	@sudo docker exec -it $(docker_php_cli) bash

connect-nginx:
	@sudo docker exec -it $(docker_nginx) bash

connect-mysql:
	@sudo docker exec -it $(docker_mysql) bash

connect-node:
	@sudo docker exec -it $(docker_node) bash