<?php

declare(strict_types=1);

namespace App\Exceptions;

class OrderException extends \Exception
{
    public const EMPTY_PRODUCTS = 1;
    public const PRODUCTS_NOT_FOUND = 2;
    public const EMPTY_ORDER_ID = 3;
    public const EMPTY_SUM = 4;
    public const INVALID_SUM = 5;
    public const INVALID_STATUS = 6;
    public const FAILED_PAYMENT = 7;

    public static function emptyProducts()
    {
        return new static('You must choose products', self::EMPTY_PRODUCTS);
    }

    public static function someProductsNotFound()
    {
        return new static('Some products not found', self::PRODUCTS_NOT_FOUND);
    }

    public static function emptyOrderId()
    {
        return new static('Empty order ID', self::EMPTY_ORDER_ID);
    }

    public static function emptySum()
    {
        return new static('Empty sum', self::EMPTY_SUM);
    }

    public static function invalidSum()
    {
        return new static('Invalid sum', self::INVALID_SUM);
    }

    public static function invalidStatus()
    {
        return new static('Invalid status', self::INVALID_STATUS);
    }

    public static function failedPay()
    {
        return new static('Failed payment', self::FAILED_PAYMENT);
    }
}
