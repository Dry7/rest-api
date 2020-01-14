<?php

declare(strict_types=1);

namespace Tests\Http\Controllers\Products;

use App\Entities\Order;
use App\Entities\Product;
use App\Exceptions\OrderException;
use App\Http\Controllers\Orders\CreateOrder;
use App\Http\Controllers\Orders\PayOrder;
use App\Http\Views\SuccessOrderPay;
use App\Request;
use App\Services\PaymentService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use PHPUnit\Framework\TestCase;

class PayOrderTest extends TestCase
{
    private Request $request;
    private EntityManagerInterface $entityManager;
    private PaymentService $paymentService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = \Mockery::mock(Request::class);
        $this->entityManager = \Mockery::mock(EntityManagerInterface::class);
        $this->paymentService = \Mockery::mock(PaymentService::class);
    }

    public function testEmptyOrderId()
    {
        // arrange
        /** @var Request $request */
        $this->request
            ->shouldReceive('jsonContent')
            ->andReturnNull()
            ->once()
            ->getMock();

        // assert
        self::expectException(OrderException::class);
        self::expectExceptionMessage('Empty order ID');

        // act
        (new PayOrder())($this->request, $this->entityManager, $this->paymentService);
    }

    public function testEmptySum()
    {
        // arrange
        /** @var Request $request */
        $this->request
            ->shouldReceive('jsonContent')
            ->andReturn((object)['id' => 1])
            ->once()
            ->getMock();

        // assert
        self::expectException(OrderException::class);
        self::expectExceptionMessage('Empty sum');

        // act
        (new PayOrder())($this->request, $this->entityManager, $this->paymentService);
    }

    public function testInvalidStatus()
    {
        // arrange
        $order = new Order();
        $order->setStatus(Order::STATUS_PAID);

        /** @var Request $request */
        $this->request
            ->shouldReceive('jsonContent')
            ->andReturn((object)['id' => 1, 'sum' => 10.00])
            ->once()
            ->getMock();
        $this->entityManager
            ->shouldReceive('getRepository')
            ->with(Order::class)
            ->once()
            ->andReturnUsing(static fn() => \Mockery::mock(ObjectRepository::class)
                ->shouldReceive('find')
                ->with(1)
                ->once()
                ->andReturn($order)
                ->getMock()
            )
            ->getMock();

        // assert
        self::expectException(OrderException::class);
        self::expectExceptionMessage('Invalid status');

        // act
        (new PayOrder())($this->request, $this->entityManager, $this->paymentService);
    }

    public function testInvalidSum()
    {
        // arrange
        $products = [
            new Product('Name 1', 10.00),
            new Product('Name 2', 4.99),
        ];
        $order = Order::createFromProducts($products);

        /** @var Request $request */
        $this->request
            ->shouldReceive('jsonContent')
            ->andReturn((object)['id' => 2, 'sum' => 15.00])
            ->once()
            ->getMock();
        $this->entityManager
            ->shouldReceive('getRepository')
            ->with(Order::class)
            ->once()
            ->andReturnUsing(static fn() => \Mockery::mock(ObjectRepository::class)
                ->shouldReceive('find')
                ->with(2)
                ->once()
                ->andReturn($order)
                ->getMock()
            )
            ->getMock();

        // assert
        self::expectException(OrderException::class);
        self::expectExceptionMessage('Invalid sum');

        // act
        (new PayOrder())($this->request, $this->entityManager, $this->paymentService);
    }

    public function testFailedPay()
    {
        // arrange
        $order = Order::createFromProducts([
            new Product('Name 3', 13.00),
            new Product('Name 4', 5.00),
        ]);

        /** @var Request $request */
        $this->request
            ->shouldReceive('jsonContent')
            ->andReturn((object)['id' => 3, 'sum' => 18.00])
            ->once()
            ->getMock();
        $this->entityManager
            ->shouldReceive('getRepository')
            ->with(Order::class)
            ->once()
            ->andReturnUsing(static fn() => \Mockery::mock(ObjectRepository::class)
                ->shouldReceive('find')
                ->with(3)
                ->once()
                ->andReturn($order)
                ->getMock()
            )
            ->getMock();
        $this->paymentService
            ->shouldReceive('pay')
            ->andReturnFalse();

        // assert
        self::expectException(OrderException::class);
        self::expectExceptionMessage('Failed payment');

        // act
        (new PayOrder())($this->request, $this->entityManager, $this->paymentService);
    }

    public function testInvoke()
    {
        // arrange
        $order = Order::createFromProducts([
            new Product('Name 1', 3.00),
            new Product('Name 5', 4.00),
        ]);

        /** @var Request $request */
        $this->request
            ->shouldReceive('jsonContent')
            ->andReturn((object)['id' => 4, 'sum' => 7.00])
            ->once()
            ->getMock();
        $this->entityManager
            ->shouldReceive('getRepository')
            ->with(Order::class)
            ->once()
            ->andReturnUsing(static fn() => \Mockery::mock(ObjectRepository::class)
                ->shouldReceive('find')
                ->with(4)
                ->once()
                ->andReturn($order)
                ->getMock()
            )
            ->getMock()
            ->shouldReceive('persist')->with($order)->once()->getMock()
            ->shouldReceive('flush')->withNoArgs()->once()->getMock();
        $this->paymentService
            ->shouldReceive('pay')
            ->andReturnTrue();

        // act
        $response = (new PayOrder())($this->request, $this->entityManager, $this->paymentService);

        self::assertInstanceOf(SuccessOrderPay::class, $response);
        self::assertEquals('{"success":true}', json_encode($response));
    }
}
