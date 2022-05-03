#!/bin/sh

export CACHE_DRIVER=redis
export DB_CONNECTION=mysql
export DB_DATABASE=wallets
export DB_PASSWORD=root

rm -rf vendor/ composer.lock
cp composer_6.x.json composer.json
composer install
composer unit
if [[ $? -ne 0 ]]; then
  exit 6
fi

mv build/junit{,-6.x}.xml

sleep 30

rm -rf vendor/ composer.lock
cp composer_7.x.json composer.json
composer install
composer unit
if [[ $? -ne 0 ]]; then
  exit 7
fi

mv build/junit{,-7.x}.xml

sleep 30

rm -rf vendor/ composer.lock
cp composer_8.x.json composer.json
composer install
composer unit
if [[ $? -ne 0 ]]; then
  exit 8
fi

mv build/junit{,-8.x}.xml

sleep 30

rm -rf vendor/ composer.lock
cp composer_9.x.json composer.json
composer install
composer unit
if [[ $? -ne 0 ]]; then
  exit 9
fi

mv build/junit{,-9.x}.xml
