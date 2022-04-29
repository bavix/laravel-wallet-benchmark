#!/bin/sh

rm -rf vendor/ composer.lock
cp composer_7.x.json composer.json
composer install
composer unit
mv build/junit{,-7.3.3}.xml

sleep 30

rm -rf vendor/ composer.lock
cp composer_8.x.json composer.json
composer install
composer unit
mv build/junit{,-8.4.1}.xml

sleep 30

rm -rf vendor/ composer.lock
cp composer_9.x.json composer.json
composer install
composer unit
mv build/junit{,-9.0.0-RC2}.xml
