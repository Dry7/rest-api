<?php

declare(strict_types=1);

namespace Tests\Entities;

use App\Entities\Order;
use App\Entities\Product;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    public function testConstructor()
    {
        // arrange
        $product = new Order();

        // assert
        self::assertInstanceOf(ArrayCollection::class, $product->products());
    }

    public function testGetAndSetId()
    {
        // arrange
        $product = new Order();
        $product->setId(43);

        // assert
        self::assertEquals($product->getId(), 43);
    }

    public function testGetDefaultStatus()
    {
        // arrange
        $product = new Order();

        // assert
        self::assertEquals($product->getStatus(), Order::STATUS_NEW);
    }

    public function testGetAndSetStatus()
    {
        // arrange
        $product = new Order();
        $product->setStatus(Order::STATUS_PAID);

        // assert
        self::assertEquals($product->getStatus(), Order::STATUS_PAID);
    }

    public function testCreateFromProductsEmpty()
    {
        // act
        $response = Order::createFromProducts([]);

        // assert
        self::assertEmpty($response->products());
    }

    public function testCreateFromProducts()
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
