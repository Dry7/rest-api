<?php

declare(strict_types=1);

namespace App\Http\Controllers\Products;

use App\Entities\Product;
use App\Services\Configuration\ConfigurationInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class CreateProducts
{
    public function __invoke(Request $request, EntityManagerInterface $entityManager, ConfigurationInterface $config): void
    {
    }
}
