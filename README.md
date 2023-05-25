# Setup project

cp .env.example .env

configure .env file

docker-compose build

docker-compose up -d

docker exec -it php-fpm-socialCRM-container bash

composer install

bin/console doc:mig:mig