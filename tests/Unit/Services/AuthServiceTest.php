<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Services\AuthService;
use PHPUnit\Framework\TestCase;

class AuthServiceTest extends TestCase
{
    public function testGetUser(): void
    {
        // arrange
        $service = new AuthService();
        $user = $service->getUser();

        // assert
        self::assertEquals(1, $user->getId());
        self::assertEquals('admin', $user->getLogin());
    }
}
