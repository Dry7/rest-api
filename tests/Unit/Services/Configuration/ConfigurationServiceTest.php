<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Services\Configuration\ConfigurationInterface;
use App\Services\Configuration\ConfigurationService;
use App\Services\DoctrineService;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;

class ConfigurationServiceTest extends TestCase
{
    /**
     * @dataProvider getDataProvider
     *
     * @param string $key
     * @param $expected
     */
    public function testGet(string $key, $expected)
    {
        // arrange
        $service = new ConfigurationService(__DIR__ . '/../../../fixtures/config/');

        // assert
        self::assertEquals($expected, $service->get($key));
    }

    public static function getDataProvider()
    {
        return [
            ['rest.app.one.two', 1],
            ['rest.app.second', [1, 2, 3]],
            ['api.key', true],
            ['api.default', null],
            ['api.invalid', null],
            ['invalid', null],
        ];
    }

    /**
     * @dataProvider hasDataProvider
     *
     * @param string $key
     * @param bool $expected
     */
    public function testHas(string $key, bool $expected)
    {
        // arrange
        $service = new ConfigurationService(__DIR__ . '/../../../fixtures/config/');

        // assert
        self::assertEquals($expected, $service->has($key));
    }

    public static function hasDataProvider()
    {
        return [
            ['rest.app.one.two', true],
            ['rest.app.second', true],
            ['api.key', true],
            ['api.default', true],
            ['api.invalid', false],
        ];
    }

    /**
     * @dataProvider setDataProvider
     *
     * @param string $key
     * @param bool $expected
     */
    public function testSet(string $key, $expected)
    {
        // arrange
        $service = new ConfigurationService(__DIR__ . '/../../../fixtures/config/');

        // act
        $service->set($key, $expected);

        // assert
        self::assertEquals($expected, $service->get($key));
    }

    public static function setDataProvider()
    {
        return [
            ['rest.app.one.two', 2],
            ['rest.app.second', false],
            ['api.key', [1, 2, 3, 5]],
            ['api.default', null],
            ['api.default2', 11],
            ['api.invalid', null],
        ];
    }
}
