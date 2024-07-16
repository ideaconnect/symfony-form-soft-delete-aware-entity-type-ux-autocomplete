#!/bin/bash
cd tests/functional \
&& docker compose down \
&& docker compose down -v \
&& docker compose build \
&& docker compose up -d --build --force-recreate \
&& docker compose exec  --workdir=/app testapp composer install \
&& docker compose exec  --workdir=/app/tests/functional testapp bin/console importmap:require tom-select/dist/css/tom-select.default.css \
&& docker compose exec  --workdir=/app/tests/functional testapp composer install \
&& docker compose exec  --workdir=/app testapp ./vendor/bin/phpunit \
&& sleep 5 \
&& docker compose exec testapp bin/console doctrine:schema:create \
&& docker compose exec testapp vendor/bin/behat