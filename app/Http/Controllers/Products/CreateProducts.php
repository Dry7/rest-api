<?php

declare(strict_types=1);

namespace App\Http\Controllers\Products;

use App\Http\Views\SuccessResponse;
use App\Services\ProductService;
use Symfony\Component\HttpFoundation\Request;

class CreateProducts
{
    public function __invoke(Request $request, ProductService $service): SuccessResponse
    {
        $service->createFakeProducts();

        return new SuccessResponse();
    }
}
