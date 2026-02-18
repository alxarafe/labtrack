#!/bin/bash
# Description: Checks coding standards using PHPCS inside the container.

# Load environment variables
if [ -f .env ]; then
    export $(cat .env | grep -v '#' | awk '/=/ {print $1}')
fi

echo "Running PHPCS en $PHP_CONTAINER..."
docker exec -it $PHP_CONTAINER ./vendor/bin/phpcs --tab-width=4 --encoding=utf-8 --standard=phpcs.xml application
docker exec -it $PHP_CONTAINER ./vendor/bin/phpcs --tab-width=4 --encoding=utf-8 --standard=phpcs.xml Tests
