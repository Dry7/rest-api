<?php

declare(strict_types=1);

namespace App;

use Symfony\Component\HttpFoundation\Request as BaseRequest;

class Request extends BaseRequest
{
    public function jsonContent()
    {
        return json_decode($this->getContent());
    }
}
