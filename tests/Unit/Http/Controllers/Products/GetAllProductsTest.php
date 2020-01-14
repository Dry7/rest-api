<?php

declare(strict_types=1);

namespace Tests\Http\Controllers\Products;

use App\Entities\Product;
use App\Http\Controllers\Products\GetAllProducts;
use App\Http\Views\ProductListView;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use PHPUnit\Framework\TestCase;

class GetAllProductsTest extends TestCase
{
    public function testInvoke()
    {
        // arrange
        $products = [
            new Product('Name 1', 10.00),
            new Product('Name 2', 20.00),
            new Product('Name 3', 5.99),
            new Product('Name 4', 30.99),
        ];
        /** @var EntityManagerInterface $entityManager */
        $entityManager = \Mockery::mock(EntityManagerInterface::class)
            ->shouldReceive('getRepository')
            ->once()
            ->andReturnUsing(static fn () => \Mockery::mock(ObjectRepository::class)
                    ->shouldReceive('findAll')
                    ->once()
                    ->andReturn($products)
                    ->getMock()
            )
            ->getMock();

        // act
        $response = (new GetAllProducts())($entityManager);

        // assert
        self::assertInstanceOf(ProductListView::class, $response);
        self::assertEquals(
            '[{"id":null,"name":"Name 1","price":10},{"id":null,"name":"Name 2","price":20},{"id":null,"name":"Name 3","price":5.99},{"id":null,"name":"Name 4","price":30.99}]',
            json_encode($response)
        );
    }
}
