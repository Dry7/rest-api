<?php

declare(strict_types=1);

namespace Tests\Unit\Entities;

use App\Entities\Order;
use App\Entities\Product;
use App\Entities\User;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    public function testConstructor(): void
    {
        // arrange
        $order = new Order();

        // assert
        self::assertInstanceOf(ArrayCollection::class, $order->products());
    }

    public function testGetAndSetId(): void
    {
        // arrange
        $order = new Order();
        $order->setId(43);

        // assert
        self::assertEquals(43, $order->getId());
    }

    public function testGetDefaultStatus(): void
    {
        // arrange
        $order = new Order();

        // assert
        self::assertEquals(Order::STATUS_NEW, $order->getStatus());
    }

    public function testGetAndSetStatus(): void
    {
        // arrange
        $order = new Order();
        $order->setStatus(Order::STATUS_PAID);

        // assert
        self::assertEquals(Order::STATUS_PAID, $order->getStatus());
    }

    public function testGetUser(): void
    {
        // arrange
        $order = new Order();

        // act
        $user = $order->user();

        // assert
        self::assertEquals(1, $user->getId());
        self::assertEquals('admin', $user->getLogin());
    }

    public function testSetUser(): void
    {
        // arrange
        $user = new User(2, 'buyer');
        $order = new Order();

        // act
        $order->setUser($user);
        $user = $order->user();

        // assert
        self::assertEquals(2, $user->getId());
        self::assertEquals('buyer', $user->getLogin());
    }

    public function testCreateFromProductsEmpty(): void
    {
        // act
        $response = Order::createFromProducts([]);

        // assert
        self::assertEmpty($response->products());
    }

    public function testCreateFromProducts(): void
    {
        // arrange
        $products = [
            new Product('Name 1', 100.00),
            new Product('Name 2', 101.99),
        ];

        // act
        $response = Order::createFromProducts($products);

        // assert
        self::assertSame($products, $response->products()->toArray());
    }
}
