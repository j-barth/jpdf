#!/bin/bash

./vendor/bin/phpunit --bootstrap tests/phpunit/autoload.php tests/phpunit/FastTests/
./vendor/bin/phpunit --bootstrap tests/phpunit/autoload.php tests/phpunit/IntegrationTests/
