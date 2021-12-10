#!/bin/sh
docker run -d -p 3306:3306 --name mysql --env MYSQL_ROOT_PASSWORD=root mysql/mysql-server
