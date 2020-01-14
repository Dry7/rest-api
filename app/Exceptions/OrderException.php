<?php

declare(strict_types=1);

namespace App\Exceptions;

class OrderException extends \Exception
{
    public const EMPTY_PRODUCTS = 1;
    public const PRODUCTS_NOT_FOUND = 2;

    public static function emptyProducts()
    {
        return new static('You must choose products', self::EMPTY_PRODUCTS);
    }

    public static function someProductsNotFound()
    {
        return new static('Some products not found', self::PRODUCTS_NOT_FOUND);
    }
}
