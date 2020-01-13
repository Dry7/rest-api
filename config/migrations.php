<?php

return [
    'name' => 'REST API migrations',
    'migrations_namespace' => 'App\Database\Migrations',
    'table_name' => 'migration',
    'column_name' => 'version',
    'column_length' => 14,
    'executed_at_column_name' => 'executed_at',
    'migrations_directory' => __DIR__ . '/../database/migrations',
    'all_or_nothing' => true,
    'check_database_platform' => true,
];
