#!/bin/bash

php bin/console make:migration
php bin/console doctrine:migrations:migrate --no-interaction

exec apache2-foreground
