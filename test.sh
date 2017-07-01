#!/bin/bash
set -e

if [ ! -d "./vendor" ]; then
    composer install
fi

./vendor/bin/phpunit ./tests