<?php

require_once __DIR__ . '/../bootstrap/app.php';

use App\Application;
use App\Http\Controllers\Products\CreateProducts;
use Symfony\Component\HttpFoundation\Request;

Application::createDI();
$application = Application::getDI();

$request = Request::createFromGlobals();

$action = parse_url($request->server->get('REQUEST_URI'), PHP_URL_PATH);

switch ($action) {
    case '/api/v1/products/create';
        echo $application->call(CreateProducts::class);
}
