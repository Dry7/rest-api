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
docker-compose build && docker-compose run --rm composer && docker-compose up
```

Manual installation
1. Copy docker-compose.override.yml.dist to docker-compose.override.yml
2. Copy .env.example to .env
3. Install composer dependencies (composer install)
4. Run migrations
```
docker-compose exec php-fpm vendor/bin/doctrine-migrations migrations:migrate --configuration=config/migrations.php
```

Routes
1. `GET /api/v1/products` All products list
2. `POST /api/v1/products/create` Create fake products
3. `POST /api/v1/orders` `POST body = [1,2,3]` Create order
4. `POST /api/v1/orders/pay` `POST body {"id": 1,"sum": 9.99}` Pay order

Code coverage report (100%)
```$xslt
/storage/coverage
```
