<?php

declare(strict_types=1);

namespace Tests\Http\Controllers\Products;

use App\Http\Controllers\Products\CreateProducts;
use App\Http\Views\SuccessResponse;
use App\Services\ProductService;
use Mockery\Mock;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class CreateProductsTest extends TestCase
{
    public function testRunService()
    {
        // arrange
        /** @var Request $request */
        $request = new Request();
        /** @var ProductService|Mock $productService */
        $productService = \Mockery::mock(ProductService::class)
            ->shouldReceive('createFakeProducts')
            ->once()
            ->getMock();

        // act
        $response = (new CreateProducts())($request, $productService);

        // assert
        self::assertInstanceOf(SuccessResponse::class, $response);
    }
}
