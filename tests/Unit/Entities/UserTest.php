<?php

declare(strict_types=1);

namespace Tests\Unit\Entities;

use App\Entities\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testConstructor(): void
    {
        // arrange
        $user = new User(2, 'buyer');

        // assert
        self::assertEquals(2, $user->getId());
        self::assertEquals('buyer', $user->getLogin());
    }

    public function testGetId(): void
    {
        // arrange
        $user = new User(3, 'buyer');

        // assert
        self::assertEquals(3, $user->getId());
    }

    public function testSetId(): void
    {
        // arrange
        $user = new User(3, 'buyer');
        $user->setId(9);

        // assert
        self::assertEquals(9, $user->getId());
    }

    public function testGetLogin(): void
    {
        // arrange
        $user = new User(3, 'buyer');

        // assert
        self::assertEquals('buyer', $user->getLogin());
    }

    public function testSetLogin(): void
    {
        // arrange
        $user = new User(3, 'buyer');
        $user->setLogin('seller');

        // assert
        self::assertEquals('seller', $user->getLogin());
    }
}
