<?php

require_once __DIR__ . '/../bootstrap/app.php';

use App\Application;
use App\Http\Controllers\Products\CreateProducts;
use App\Http\Controllers\Products\GetAllProducts;
use Symfony\Component\HttpFoundation\Request;

Application::createDI();
$application = Application::getDI();

$request = Request::createFromGlobals();

$action = parse_url($request->server->get('REQUEST_URI'), PHP_URL_PATH);

function routes(\DI\Container $application, string $action)
{
    switch ($action) {
        case '/api/v1/products/create';
            return $application->call(CreateProducts::class);

        case '/api/v1/products';
            return $application->call(GetAllProducts::class);
    }

    return 404;
}

echo json_encode(routes($application, $action));
