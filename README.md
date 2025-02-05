# Symfony TodoList
A simple TodoList application built with Symfony 7.2 and Docker.

## Installation

1. Clone the repository
2. Copy the `./src/.env.dev` file to `./src/.env`
3. Run `docker-compose up --build`
4. Access to the www container and run `php bin/console doctrine:database:create`
5. Access to the www container and run `php bin/console doctrine:migrations:migrate`
6. Go to http://localhost:80 to see the application

```shell
git clone https://github.com/mrsxnshxne/symfony-todolist.git symfony-todolist
cd symfony-todolist

cp ./src/.env.dev ./src/.env

docker exec -it symfony-todolist-www-1 bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate

docker-compose up --build
```

## About Compose

The `docker-compose.yml` file contains the following services:
- `www` - The Apache container (port: 80)
- `db` - The MariaDB container (port: 3306)
- `phpmyadmin` - The PhpMyAdmin container (port: 8080)

## Specifications

- PHP 8.2.27
- Apache 2.4.62
- MariaDB 11.6.2
- PhpMyAdmin 5.2.1

## Scripts

- `sync-vendor.sh` - Copy the container's vendor directory to the host machine