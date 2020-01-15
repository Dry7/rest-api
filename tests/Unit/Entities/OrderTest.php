<?php

declare(strict_types=1);

namespace Tests\Unit\Entities;

use App\Entities\Order;
use App\Entities\Product;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    public function testConstructor(): void
    {
        // arrange
        $product = new Order();

        // assert
        self::assertInstanceOf(ArrayCollection::class, $product->products());
    }

    public function testGetAndSetId(): void
    {
        // arrange
        $product = new Order();
        $product->setId(43);

        // assert
        self::assertEquals($product->getId(), 43);
    }

    public function testGetDefaultStatus(): void
    {
        // arrange
        $product = new Order();

        // assert
        self::assertEquals($product->getStatus(), Order::STATUS_NEW);
    }

    public function testGetAndSetStatus(): void
    {
        // arrange
        $product = new Order();
        $product->setStatus(Order::STATUS_PAID);

        // assert
        self::assertEquals($product->getStatus(), Order::STATUS_PAID);
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
        self::assertSame($response->products()->toArray(), $products);
    }
}
