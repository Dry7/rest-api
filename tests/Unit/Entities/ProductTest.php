<?php

declare(strict_types=1);

namespace Tests\Unit\Entities;

use App\Entities\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function testConstructor(): void
    {
        // arrange
        $product = new Product('Name 1', 10.00);

        // assert
        self::assertEquals([
            'id' => null,
            'name' => 'Name 1',
            'price' => 10.00,
        ], $product->toArray());
    }

    public function testGetId(): void
    {
        // arrange
        $product = new Product('Test', 99.99);
        $product->setId(20);

        // assert
        self::assertEquals($product->getId(), 20);
    }

    public function testSetId(): void
    {
        // arrange
        $product = new Product('Test', 99.99);
        $product->setId(18);

        // assert
        self::assertEquals([
            'id' => 18,
            'name' => 'Test',
            'price' => 99.99,
        ], $product->toArray());
    }

    public function testGetName(): void
    {
        // arrange
        $product = new Product('Test', 99.99);

        // assert
        self::assertEquals($product->getName(), 'Test');
    }

    public function testSetName(): void
    {
        // arrange
        $product = new Product('Test', 99.99);
        $product->setName('New');

        // assert
        self::assertEquals([
            'id' => null,
            'name' => 'New',
            'price' => 99.99,
        ], $product->toArray());
    }

    public function testGetPrice(): void
    {
        // arrange
        $product = new Product('Test', 99.99);

        // assert
        self::assertEquals($product->getPrice(), 99.99);
    }

    public function testSetPrice(): void
    {
        // arrange
        $product = new Product('Test', 99.99);
        $product->setPrice(21.00);

        // assert
        self::assertEquals([
            'id' => null,
            'name' => 'Test',
            'price' => 21.00,
        ], $product->toArray());
    }
}
