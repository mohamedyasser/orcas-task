# Orcas Task

# Getting started

## Installation

Clone the repository

    git clone https://github.com/mohamedyasser/orcas-task

## how to make it work
- open terminal in project dir
- run command `docker run --rm -v ${PWD}:/app composer install`
- run command `docker-compose build --no-cache`
- then run command `docker-compose up -d`
- then run command `docker-compose exec app php artisan key:generate`
- then run command `docker-compose exec app php artisan optimize`
- then run command `docker-compose exec app php artisan migrate`
- then run command `docker-compose exec app php artisan apikey:generate orcas`
- then run command `docker-compose exec app php artisan schedule:work`

- api url `http://localhost:8080` auth using generated by command `docker-compose exec app php artisan apikey:generate orcas`
- X-Authorization: {{generated api key}}

## users list

### `GET`: /api/v1/users/search
- GET Query  `page`  (optional)  `int`  (default: 1)  `page number`

## search in users
### `GET`: /api/v1/users/search
- GET Query  `page`  (optional)  `int`  (default: 1)  `page number`
- GET Query  `first_name`
- GET Query  `last_name`
- GET Query  `email`
