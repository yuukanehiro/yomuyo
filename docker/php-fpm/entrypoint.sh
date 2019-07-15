#!/bin/bash

php artisan cache:clear
php artisan migrate
