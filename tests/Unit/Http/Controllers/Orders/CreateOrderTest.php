<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Controllers\Orders;

use App\Entities\Product;
use App\Entities\User;
use App\Exceptions\OrderException;
use App\Http\Controllers\Orders\CreateOrder;
use Tests\Unit\TestCase;

class CreateOrderTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testEmptyProducts(): void
    {
        // arrange
        $this->mockJsonContent(null);

        // assert
        self::expectException(OrderException::class);
        self::expectExceptionMessage('You must choose products');

        // act
        (new CreateOrder())($this->request, $this->entityManager, $this->authService);
    }

    public function testNotFoundProducts(): void
    {
        // arrange
        $product = new Product('Name', 100.00);
        $this->mockJsonContent([1, 'test', 2344234]);
        $this->mockFindByIDs([1, null, 2344234], [$product]);

        // assert
        self::expectException(OrderException::class);
        self::expectExceptionMessage('Some products not found');

        // act
        (new CreateOrder())($this->request, $this->entityManager, $this->authService);
    }

    public function testInvoke(): void
    {
        // arrange
        $products = [
            new Product('Name 1', 33.00),
            new Product('Name 2', 23.00),
        ];
        $this->mockJsonContent([1, 2]);
        $this->mockFindByIDs([1, 2], $products);
        $this->entityManager
            ->shouldReceive('persist')->once()->getMock()
            ->shouldReceive('flush')->once()->getMock();
        $this->mockAuth(new User());

        // act
        $response = (new CreateOrder())($this->request, $this->entityManager, $this->authService);

        self::assertSame('{"id":null}', json_encode($response));
    }
}
