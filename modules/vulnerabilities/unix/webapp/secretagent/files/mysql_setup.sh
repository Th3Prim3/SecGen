#!/bin/sh

USERNAME=${1}
PASSWORD=${2}
token=${3}

echo "CREATE USER '${USERNAME}'@'localhost' IDENTIFIED BY '${PASSWORD}';"| mysql --force
echo "GRANT ALL PRIVILEGES ON * . * TO '${USERNAME}'@'localhost';"| mysql --force
echo "CREATE DATABASE secretagent;"| mysql --user=${USERNAME} --password=${PASSWORD} --force
mysql --force --user=${USERNAME} --password=${PASSWORD} secretagent < ./secretagent.sql

echo "USE secretagent; INSERT INTO token VALUES ('${token}');" |  mysql --force --user=${USERNAME} --password=${PASSWORD}