<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Controllers\Products;

use App\Http\Controllers\Products\CreateProducts;
use App\Http\Views\SuccessResponse;
use App\Services\ProductService;
use Mockery\Mock;
use Tests\Unit\TestCase;

class CreateProductsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testInvoke(): void
    {
        // arrange
        /** @var ProductService|Mock $productService */
        $productService = \Mockery::mock(ProductService::class)
            ->shouldReceive('createFakeProducts')
            ->once()
            ->getMock();

        // act
        $response = (new CreateProducts())($productService);

        // assert
        self::assertInstanceOf(SuccessResponse::class, $response);
    }
}
