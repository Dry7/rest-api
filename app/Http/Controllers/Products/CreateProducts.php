<?php

declare(strict_types=1);

namespace App\Http\Controllers\Products;

use App\Http\Views\SuccessResponse;
use App\Services\ProductService;

class CreateProducts
{
    public function __invoke(ProductService $service): SuccessResponse
    {
        $count = 0;
        foreach ($service->createFakeProducts() as $product) {
            ++$count;
        }

        return new SuccessResponse($count . ' products added');
    }
}
