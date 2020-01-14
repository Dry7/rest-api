<?php

declare(strict_types=1);

namespace Tests\Http\Controllers\Products;

use App\Services\Configuration\ConfigurationInterface;
use App\Services\DoctrineService;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;

class DoctrineServiceTest extends TestCase
{
    public function testBuild()
    {
        echo getenv('DATABASE_DBNAME');
        // arrange
        /** @var ConfigurationInterface $config */
        $config = \Mockery::mock(ConfigurationInterface::class)->shouldReceive('get')->once()->andReturn(require __DIR__ . '/../../../config/database.php')->getMock();
        $service = new DoctrineService($config);

        // assert
        self::assertInstanceOf(EntityManager::class, $service->build());
    }
}
