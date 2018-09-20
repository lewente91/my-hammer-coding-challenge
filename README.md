# MyHammer Coding Challenge Service
## Table of contents
1. [Prerequisites](#prerequisites)
2. [General project information](#general-project-information)
3. [Setup](#general-project-information)
4. [Tests](#tests)
5. [Future plans](#future-plans)

## Prerequisites
The following are required to run the project:
- git
- GNU make (although technically not required, but it makes it easier)
- docker
- docker-compose

## General project information
The project is contained with docker. Containers are using the `APP_NAME` environment variable from the `.env`
file, in development, to prefix each container and tie them to a specific project using the `-p` flag from docker. The
`APP_NAME` variable defaults to `my_hammer`.
The following containers are available:
- `<APP_NAME>_db`: MySql version 5.7, binds to port 3306 on the host, has volume (to prevent data loss on container
shutdown)
- `<APP_NAME>_nginx`: simple web server, binds to port 80 on the host
- `<APP_NAME>_php`: php-fpm 7.2 with composer, exposes port 9000 internally

The included `Makefile` makes it a lot easier to manage docker related operations (and not only). By typing `make`
into the command line, the list of targets will appear. These are the following:
- `help`: This help
- `up`: Start project specific web and PHP containers
- `up-build`: Start and build project specific web and PHP containers
- `vendor`: Composer install in the php container
- `stop`: Stop project specific containers
- `prune`: Stop and remove project specific containers
- `prune-volume`: Stop and remove project specific containers and volumes
- `ps`: List project specific containers
- `migrate`: Run database migrations
- `seed`: Create test data

Sample data is introduced into the system using doctrine's data fixture bundle. All the data fixture classes are located
under `src\DataFixtures` directory.

User authentication is achieved with a dummy pre authenticator, which fetches a given user from the database.

In `dev` environment access `/api/doc` for an API Documentation. In case the containers are running, this api doc
can be also used to make requests.

## Setup
```bash
# clone the project
git clone git@github.com:lewente91/my-hammer-coding-challenge.git .

# start containers, for the first run it will build images, because they are non-existent
make up

# does composer install using the committed composer.lock file
make vendor

# runs database migrations
make migrate

# populates the database with sample data (cities, services, user)
make seed
```

## Tests
Test too are contained with docker. Works the same as all the other containers in regard of `APP_NAME`, `.env` file and
`-p` docker flag.

A single container under the name of `<APP_NAME>_test` is created with `composer` and `xdebug`.
The included `Makefile` facilitates the following commands regarding testing:
- `test-build`: Build and start test container, create report directories
- `test-build-vendor`: Composer install in the test container
- `test-phpunit`: Run PHPUnit tests
- `test-prune`: Remove test container

Running `make test-phpunit` creates the following logs in the `reports/coverage` directory:
- `html`: for bette visualisation of the coverage report (open with `index.html`)
- `clover.xml`: clover coverage in xml format
- `crap4j.xml`: CRAP (Change Risk Analysis and Predictions) software metric in xml format

## Future plans
- add more `unit tests`
- add other metrics to the project `phpstan`, `phpcs`, `phpmd`
- change `MyHammer\Api\EventSubscriber\ExceptionSubscriber` to use strategy pattern based on the exception thrown
- improve `Makefile` (add migration generation, etc.)
- change `Schedule` from `ENUM` to an entity in order to make management development free
- add `behavioural tests (Behat)` (this is why controllers are excluded in phpunit.xml)
- cleanup configuration (improve, remove unused ones)
