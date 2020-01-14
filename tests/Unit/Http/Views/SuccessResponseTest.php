<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Views;

use App\Http\Views\SuccessResponse;
use PHPUnit\Framework\TestCase;

class SuccessResponseTest extends TestCase
{
    public function testConstructor()
    {
        // arrange
        $view = new SuccessResponse();

        // assert
        self::assertInstanceOf(SuccessResponse::class, $view);
        self::assertEquals('{"success":true}', json_encode($view));
    }
}
