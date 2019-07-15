#!/bin/bash

php artisan cache:clear --force
php artisan migrate --force
