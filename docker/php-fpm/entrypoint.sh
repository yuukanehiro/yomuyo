#!/bin/bash

set -e

# スクリプトディレクトリの取得
SCRIPT_DIR=`dirname $0`
cd $SCRIPT_DIR

php artisan cache:clear
php artisan migrate
