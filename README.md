# Symfony Docker Template
A Symfony 7.2 project template with complete dev. environment under Docker

## Installation

1. Clone the repository
2. Run `docker-compose up --build`

```shell
git clone https://github.com/mrsxnshxne/symfony-docker.git symfony-docker
cd symfony-docker
docker-compose up --build
```

## Specifications

- PHP 8.2.27
- Apache 2.4.62
- MariaDB 11.6.2
- PhpMyAdmin 5.2.1

## Scripts

- `sync-vendor.sh` - Copy the container's vendor directory to the host machine