<?php

declare(strict_types=1);

namespace App\Http\Views;

class SuccessResponse implements \JsonSerializable
{
    private string $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public function jsonSerialize()
    {
        return ['success' => true, 'message' => $this->message];
    }
}
