#!/bin/sh

composer req bavix/laravel-wallet:6.0.4
composer req bavix/laravel-wallet-vacuum:1.0.1
composer unit
mv build/junit{,-6.0.4}.xml

sleep 5

composer req bavix/laravel-wallet:6.1.0
composer req bavix/laravel-wallet-vacuum:1.0.1
composer unit
mv build/junit{,-6.1.0}.xml

sleep 5

composer remove bavix/laravel-wallet-vacuum
composer req bavix/laravel-wallet:6.2.4
composer unit
mv build/junit{,-6.2.4}.xml

sleep 5

composer req bavix/laravel-wallet:7.0.0
composer unit
mv build/junit{,-7.0.0}.xml

sleep 5

composer req bavix/laravel-wallet:7.1.0
composer unit
mv build/junit{,-7.1.0}.xml

sleep 5

composer req bavix/laravel-wallet:7.2.0
composer unit
mv build/junit{,-7.2.0}.xml

sleep 5

composer req bavix/laravel-wallet:7.3.0-beta1
composer unit
mv build/junit{,-7.3.0-beta1}.xml
