<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    /**
     * @dataProvider jsonContentDataProvider
     *
     * @param string $json
     * @param $expected
     */
    public function testJsonContent(?string $json, $expected)
    {
        // arrange
        $request = new Request([], [], [], [], [], [], $json);

        // assert
        self::assertEquals($request->jsonContent(), $expected);
    }

    public static function jsonContentDataProvider()
    {
        return [
            'integer array' => [
                '[1,2,3]',
                [1, 2, 3],
            ],
            'null' => [
                null,
                null,
            ],
            'string array' => [
                '["one", "two"]',
                ['one', 'two'],
            ],
            'object' => [
                '{"key": 1}',
                (object)['key' => 1],
            ]
        ];
    }
}
