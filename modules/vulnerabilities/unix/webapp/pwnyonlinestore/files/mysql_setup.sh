#!/bin/sh

USERNAME=${1}
PASSWORD=${2}
token=${3}

echo "CREATE USER '${USERNAME}'@'localhost' IDENTIFIED BY '${PASSWORD}';"| mysql --force
echo "GRANT ALL PRIVILEGES ON * . * TO '${USERNAME}'@'localhost';"| mysql --force
echo "CREATE DATABASE pwny;"| mysql --user=${USERNAME} --password=${PASSWORD} --force
mysql --force --user=${USERNAME} --password=${PASSWORD} pwny < ./pwny.sql

echo "USE pwny; INSERT INTO token VALUES ('${token}');" |  mysql --force --user=${USERNAME} --password=${PASSWORD}