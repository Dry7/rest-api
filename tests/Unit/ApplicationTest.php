<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Application;
use App\Request;
use App\Services\Configuration\ConfigurationInterface;
use App\Services\PaymentService;
use App\Services\ProductService;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Generator;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class ApplicationTest extends TestCase
{
    public function testCreateDI(): void
    {
        // arrange
        $app = Application::getDI();

        // assert
        self::assertInstanceOf(Request::class, $app->get(Request::class));
        self::assertInstanceOf(ConfigurationInterface::class, $app->get(ConfigurationInterface::class));
        self::assertInstanceOf(EntityManagerInterface::class, $app->get(EntityManagerInterface::class));
        self::assertInstanceOf(Generator::class, $app->get(Generator::class));
        self::assertInstanceOf(Client::class, $app->get(Client::class));
        self::assertInstanceOf(ProductService::class, $app->get(ProductService::class));
        self::assertInstanceOf(PaymentService::class, $app->get(PaymentService::class));
    }
}
