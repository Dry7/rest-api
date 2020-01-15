<?php

declare(strict_types=1);

namespace App\Http\Views;

use App\Entities\Order;

class SuccessOrderPay implements \JsonSerializable
{
    private Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function jsonSerialize()
    {
        return ['success' => true];
    }
}
