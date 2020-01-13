<?php

declare(strict_types=1);

return [
    'driver' => getenv('DATABASE_DRIVER') ?? 'pdo_pgsql',
    'host' => getenv('DATABASE_HOST') ?? 'postgres',
    'user' => getenv('DATABASE_USER') ?? 'rest-api',
    'password' => getenv('DATABASE_PASSWORD') ?? 'rest-api',
    'dbname' => getenv('DATABASE_DBNAME') ?? 'rest-api',
];
