## eArchive

### Copy ENV file

- cp .env.example .env

### Update configs in ENV file

MAIL_FROM_ADDRESS = Set outgoing email

### Docker

- go to docker-compose folder
- docker compose up -d

## All following commands in php container

### Install composer dependencies

- composer install

### Set storage link

- php artisan storage:link

### Migrate and seed database

- php artisan migrate
- php artisan db:seed
