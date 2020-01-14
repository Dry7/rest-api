<?php

declare(strict_types=1);

namespace Tests\Http\Controllers\Products;

use App\Entities\Product;
use App\Services\ProductService;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Generator;
use PHPUnit\Framework\TestCase;

class ProductServiceTest extends TestCase
{
    public function testCreateFakeProducts()
    {
        // arrange
        $products = [
            new Product('Name 1', 100.00),
            new Product('Name 2', 9.99),
            new Product('Name 3', 30.00),
        ];
        /** @var Generator $faker */
        $faker = \Mockery::mock(Generator::class)
            ->shouldReceive('sentence')
            ->with(2)
            ->andReturn('Name 1', 'Name 2', 'Name 3')
            ->getMock()
            ->shouldReceive('randomFloat')
            ->with(2, 1, 200)
            ->andReturn(100.00, 9.99, 30.00)
            ->getMock();
        /** @var EntityManagerInterface $entityManager */
        $entityManager = \Mockery::mock(EntityManagerInterface::class)
            ->shouldReceive('persist')
            ->times(3)
            ->getMock()
            ->shouldReceive('flush')
            ->once()
            ->getMock();
        $service = new ProductService($entityManager, $faker);

        // act
        /** @var Product[] $response */
        $response = iterator_to_array($service->createFakeProducts(3));

        // assert
        /** @var Product $product */
        foreach ($products as $i => $product) {
            self::assertSame($product->toArray(), $response[$i]->toArray());
        }
    }
}
