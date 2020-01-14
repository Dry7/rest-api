<?php

require_once __DIR__ . '/../bootstrap/app.php';

use App\Application;
use App\Http\Controllers\Products\CreateProducts;
use App\Http\Controllers\Products\GetAllProducts;
use App\Http\Controllers\Orders\CreateOrder;
use App\Http\Controllers\Orders\PayOrder;
use Symfony\Component\HttpFoundation\Request;

Application::createDI();
$application = Application::getDI();

$request = Request::createFromGlobals();

function routes(\DI\Container $application, Request $request)
{
    $action = parse_url($request->server->get('REQUEST_URI'), PHP_URL_PATH);
    $method = $request->getMethod();

    switch ($method) {
        case Request::METHOD_GET:
            switch ($action) {
                case '/api/v1/products';
                    return $application->call(GetAllProducts::class);
            }
            break;
        case Request::METHOD_POST:
            switch ($action) {
                case '/api/v1/products/create';
                    return $application->call(CreateProducts::class);

                case '/api/v1/orders';
                    return $application->call(CreateOrder::class);

                case '/api/v1/orders/pay';
                    return $application->call(PayOrder::class);
            }
            break;
    }

    return 404;
}

try {
    echo json_encode(routes($application, $request));
} catch (Exception $exception) {
    echo json_encode([
        'status' => 'failed',
        'message' => $exception->getMessage(),
        'code' => $exception->getCode(),
    ]);
}
