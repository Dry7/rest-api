<?php

declare(strict_types=1);

namespace App;

use App\Services\Configuration\ConfigurationInterface;
use App\Services\Configuration\ConfigurationService;
use App\Services\DoctrineService;
use App\Services\PaymentService;
use App\Services\ProductService;
use DI\Container;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Faker\Generator;
use GuzzleHttp\Client;

class Application
{
    protected static Container $di;

    public static function getDI(): Container
    {
        if (is_null(static::$di)) {
            static::createDI();
        }

        return static::$di;
    }

    public static function createDI(): void
    {
        $container = new Container();

        $container->set(Request::class, Request::createFromGlobals());
        $container->set(ConfigurationInterface::class, new ConfigurationService());
        $container->set(EntityManagerInterface::class, fn (Container $container) => (new DoctrineService($container->get(ConfigurationInterface::class)))->build());
        $container->set(Generator::class, Factory::create());
        $container->set(Client::class, new Client());
        $container->set(ProductService::class, fn (Container $container) => new ProductService($container->get(EntityManagerInterface::class), $container->get(Generator::class)));
        $container->set(PaymentService::class, fn (Container $container) => new PaymentService($container->get(Client::class)));

        self::$di = $container;
    }
}
