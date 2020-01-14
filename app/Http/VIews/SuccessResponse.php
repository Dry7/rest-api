<?php

declare(strict_types=1);

namespace App\Http\Views;

class SuccessResponse implements \JsonSerializable
{
    public function jsonSerialize()
    {
        return ['success' => true];
    }
}
