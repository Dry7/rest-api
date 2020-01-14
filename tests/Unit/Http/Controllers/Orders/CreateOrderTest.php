<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Controllers\Orders;

use App\Entities\Product;
use App\Exceptions\OrderException;
use App\Http\Controllers\Orders\CreateOrder;
use App\Request;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use PHPUnit\Framework\TestCase;

class CreateOrderTest extends TestCase
{
    public function testEmptyProducts()
    {
        // arrange
        /** @var Request $request */
        $request = \Mockery::mock(Request::class)
            ->shouldReceive('jsonContent')
            ->andReturnNull()
            ->once()
            ->getMock();
        $entityManager = \Mockery::mock(EntityManagerInterface::class);

        // assert
        self::expectException(OrderException::class);
        self::expectExceptionMessage('You must choose products');

        // act
        (new CreateOrder())($request, $entityManager);
    }

    public function testNotFoundProducts()
    {
        // arrange
        $product = new Product('Name', 100.00);
        /** @var Request $request */
        $request = \Mockery::mock(Request::class)
            ->shouldReceive('jsonContent')
            ->andReturn([1, 'test', 2344234])
            ->once()
            ->getMock();
        $entityManager = \Mockery::mock(EntityManagerInterface::class)
            ->shouldReceive('getRepository')
            ->with(Product::class)
            ->once()
            ->andReturnUsing(static fn() => \Mockery::mock(ObjectRepository::class)
                ->shouldReceive('findByIDs')
                ->with(...[1, null, 2344234])
                ->once()
                ->andReturn([$product])
                ->getMock()
            )
            ->getMock();

        // assert
        self::expectException(OrderException::class);
        self::expectExceptionMessage('Some products not found');

        // act
        (new CreateOrder())($request, $entityManager);
    }

    public function testInvoke()
    {
        // arrange
        $products = [
            new Product('Name 1', 33.00),
            new Product('Name 2', 23.00),
        ];
        /** @var Request $request */
        $request = \Mockery::mock(Request::class)
            ->shouldReceive('jsonContent')
            ->andReturn([1, 2])
            ->once()
            ->getMock();
        $entityManager = \Mockery::mock(EntityManagerInterface::class)
            ->shouldReceive('getRepository')
            ->with(Product::class)
            ->once()
            ->andReturnUsing(static fn() => \Mockery::mock(ObjectRepository::class)
                ->shouldReceive('findByIDs')
                ->with(...[1, 2])
                ->once()
                ->andReturn($products)
                ->getMock()
            )
            ->getMock()
            ->shouldReceive('persist')->once()->getMock()
            ->shouldReceive('flush')->once()->getMock();

        // act
        $response = (new CreateOrder())($request, $entityManager);

        self::assertSame('{"id":null}', json_encode($response));
    }
}
