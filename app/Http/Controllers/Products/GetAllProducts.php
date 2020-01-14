<?php

declare(strict_types=1);

namespace App\Http\Controllers\Products;

use App\Entities\Product;
use App\Http\Views\ProductListView;
use Doctrine\ORM\EntityManagerInterface;

class GetAllProducts
{
    public function __invoke(EntityManagerInterface $entityManager): ProductListView
    {
        return new ProductListView(
            $entityManager->getRepository(Product::class)->findAll()
        );
    }
}
