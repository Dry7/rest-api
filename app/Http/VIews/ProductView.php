<?php

declare(strict_types=1);

namespace App\Http\Views;

use App\Entities\Product;

class ProductView implements \JsonSerializable
{
    private Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function jsonSerialize(): array
    {
        return $this->product->toArray();
    }
}
