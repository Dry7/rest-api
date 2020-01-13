<?php

declare(strict_types=1);

namespace App;

use App\Services\Configuration\ConfigurationInterface;
use App\Services\Configuration\ConfigurationService;
use App\Services\DoctrineService;
use DI\Container;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

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

        self::$di = $container;
    }
}
