<?php

declare(strict_types=1);

namespace App\Services;

use App\Entities\Product;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Generator;

class ProductService
{
    private const FAKE_PRODUCTS = 20;

    private EntityManagerInterface $entityManager;
    private Generator $faker;

    public function __construct(EntityManagerInterface $entityManager, Generator $faker)
    {
        $this->entityManager = $entityManager;
        $this->faker = $faker;
    }

    public function createFakeProducts($count = self::FAKE_PRODUCTS): \Traversable
    {
        for ($i = 0; $i < $count; ++$i) {
            $product = $this->createFakeProduct();
            $this->entityManager->persist($product);
            yield $product;
        }
        $this->entityManager->flush();
    }

    private function createFakeProduct(): Product
    {
        return new Product(
            $this->faker->sentence(2),
            $this->faker->randomFloat(2, 1, 200)
        );
    }
}
