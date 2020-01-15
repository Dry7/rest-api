<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Controllers\Orders;

use App\Entities\Order;
use App\Entities\Product;
use App\Entities\User;
use App\Exceptions\OrderException;
use App\Http\Controllers\Orders\PayOrder;
use App\Http\Views\SuccessOrderPay;
use App\Services\PaymentService;
use Tests\Unit\TestCase;

class PayOrderTest extends TestCase
{
    private PaymentService $paymentService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->paymentService = \Mockery::mock(PaymentService::class);
    }

    public function testEmptyOrderId(): void
    {
        // arrange
        $this->mockJsonContent(null);

        // assert
        self::expectException(OrderException::class);
        self::expectExceptionMessage('Empty order ID');

        // act
        (new PayOrder())($this->request, $this->entityManager, $this->paymentService, $this->authService);
    }

    public function testEmptySum(): void
    {
        // arrange
        $this->mockJsonContent((object)['id' => 1]);

        // assert
        self::expectException(OrderException::class);
        self::expectExceptionMessage('Empty sum');

        // act
        (new PayOrder())($this->request, $this->entityManager, $this->paymentService, $this->authService);
    }

    public function testInvalidStatus(): void
    {
        // arrange
        $order = new Order();
        $order->setStatus(Order::STATUS_PAID);

        $this->mockJsonContent((object)['id' => 1, 'sum' => 10.00]);
        $this->mockRepositoryFind(Order::class, 1, $order);

        // assert
        self::expectException(OrderException::class);
        self::expectExceptionMessage('Invalid status');

        // act
        (new PayOrder())($this->request, $this->entityManager, $this->paymentService, $this->authService);
    }

    public function testAccessDenied(): void
    {
        // arrange
        $products = [
            new Product('Name 1', 10.00),
            new Product('Name 2', 4.99),
        ];
        $order = Order::createFromProducts($products);

        $this->mockJsonContent((object)['id' => 2, 'sum' => 15.00]);
        $this->mockRepositoryFind(Order::class, 2, $order);
        $this->mockAuth(new User(2));

        // assert
        self::expectException(OrderException::class);
        self::expectExceptionMessage('Access denied');

        // act
        (new PayOrder())($this->request, $this->entityManager, $this->paymentService, $this->authService);
    }

    public function testInvalidSum(): void
    {
        // arrange
        $products = [
            new Product('Name 1', 10.00),
            new Product('Name 2', 4.99),
        ];
        $order = Order::createFromProducts($products);

        $this->mockJsonContent((object)['id' => 2, 'sum' => 15.00]);
        $this->mockRepositoryFind(Order::class, 2, $order);
        $this->mockAuth(new User());

        // assert
        self::expectException(OrderException::class);
        self::expectExceptionMessage('Invalid sum');

        // act
        (new PayOrder())($this->request, $this->entityManager, $this->paymentService, $this->authService);
    }

    public function testFailedPay(): void
    {
        // arrange
        $order = Order::createFromProducts([
            new Product('Name 3', 13.00),
            new Product('Name 4', 5.00),
        ]);

        $this->mockJsonContent((object)['id' => 3, 'sum' => 18.00]);
        $this->mockRepositoryFind(Order::class, 3, $order);
        $this->paymentService
            ->shouldReceive('pay')
            ->andReturnFalse();
        $this->mockAuth(new User());

        // assert
        self::expectException(OrderException::class);
        self::expectExceptionMessage('Failed payment');

        // act
        (new PayOrder())($this->request, $this->entityManager, $this->paymentService, $this->authService);
    }

    public function testInvoke(): void
    {
        // arrange
        $order = Order::createFromProducts([
            new Product('Name 1', 3.00),
            new Product('Name 5', 4.00),
        ]);

        $this->mockJsonContent((object)['id' => 4, 'sum' => 7.00]);
        $this->mockRepositoryFind(Order::class, 4, $order);
        $this->entityManager
            ->shouldReceive('persist')->with($order)->once()->getMock()
            ->shouldReceive('flush')->withNoArgs()->once()->getMock();
        $this->paymentService
            ->shouldReceive('pay')
            ->andReturnTrue();
        $this->mockAuth(new User());

        // act
        $response = (new PayOrder())($this->request, $this->entityManager, $this->paymentService, $this->authService);

        self::assertInstanceOf(SuccessOrderPay::class, $response);
        self::assertEquals('{"success":true}', json_encode($response));
    }
}
