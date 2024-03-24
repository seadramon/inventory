#!/bin/sh
docker-compose up -d --build inventory_wton;
docker exec inventory_wton bash -c "composer install;php artisan optimize:clear"
#docker restart nginx;
#docker restart dashboard;