#!/bin/bash

# Run composer install
composer install

# Run docker-compose up with build and detached mode
docker-compose up --build -d

# Run the migration scripts
php artisan migrate --force