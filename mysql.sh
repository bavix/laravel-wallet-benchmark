#!/bin/sh
docker run -d -p 3306:3306 --name mysql --platform linux/x86_64 --env MYSQL_ROOT_PASSWORD=root mysql
