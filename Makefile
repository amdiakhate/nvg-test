path = .docker
start:
	cd $(path) && docker-sync-stack start

stop:
	cd $(path) && docker-sync-stack clean

test:
	cd $(path) && docker-compose exec api-nv ./bin/phpunit

composer-install:
	cd $(path) && docker-compose exec api-nv composer install

workers:
	cd $(path) && docker-compose exec api-nv php bin/console messenger:consume -vv