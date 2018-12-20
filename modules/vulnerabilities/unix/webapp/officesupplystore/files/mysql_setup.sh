#!/bin/sh

USERNAME=${1}
PASSWORD=${2}
token=${3}

echo "CREATE USER '${USERNAME}'@'localhost' IDENTIFIED BY '${PASSWORD}';"| mysql --force
echo "GRANT ALL PRIVILEGES ON * . * TO '${USERNAME}'@'localhost';"| mysql --force
echo "CREATE DATABASE officesupply;"| mysql --user=${USERNAME} --password=${PASSWORD} --force
mysql --force --user=${USERNAME} --password=${PASSWORD} officesupply < ./officesupply.sql

echo "USE officesupply; INSERT INTO token VALUES ('${token}');" |  mysql --force --user=${USERNAME} --password=${PASSWORD}