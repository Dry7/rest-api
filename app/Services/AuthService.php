<?php

declare(strict_types=1);

namespace App\Services;

use App\Entities\User;

class AuthService
{
    public function getUser(): User
    {
        return new User();
    }
}
