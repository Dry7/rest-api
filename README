Create migration
```
docker-compose exec php-fpm vendor/bin/doctrine-migrations migrations:diff --configuration=config/migrations.php
```

Execute migrations
```
docker-compose exec php-fpm vendor/bin/doctrine-migrations migrations:migrate --configuration=config/migrations.php
```

Tests
```
docker-compose run --rm phpunit
or
docker-compose run --rm phpunit vendor/bin/phpunit --coverage-html=storage/coverage
```

Requirements
1. Docker 18.06.0+
2. Docker-compose 1.25+

Automatic installation
```
docker-compose build && docker-compose up
```

Manual installation
1. Copy docker-compose.override.yml.dist to docker-compose.override.yml
2. Copy .env.example to .env
3. Install composer dependencies (composer install)
