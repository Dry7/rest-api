<?php

declare(strict_types=1);

namespace App\Http\Views;

class ProductListView implements \JsonSerializable
{
    private array $products;

    public function __construct(array $products)
    {
        $this->products = $products;
    }

    public function toArray(): \Traversable
    {
        foreach ($this->products as $product) {
            yield new ProductView($product);
        }
    }

    public function jsonSerialize(): array
    {
        return iterator_to_array($this->toArray());
    }
}
