### Command list:
* Get list: `/api/list`
* Newest rate: `/api/newest-rate/{CODENAME}`
* Average rate: `/api/average-rate/{CODENAME}`

### Install project (with Docker):
* `make docker-build`
* create apps/laravel/.env file (see apps/laravel/.env.example)
* set APP_KEY value in .env
* `docker-compose exec php-cli composer install`
* `docker-compose exec php-cli php artisan migrate`