<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Entities\Product;
use App\Repositories\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Persisters\Entity\EntityPersister;
use Doctrine\ORM\UnitOfWork;
use PHPUnit\Framework\TestCase;

class ProductRepositoryTest extends TestCase
{
    public function testFindByIDs(): void
    {
        // arrange
        $product = new Product('Name 1', 100.00);
        /** @var EntityManagerInterface $entityManager */
        $entityManager = \Mockery::mock(EntityManagerInterface::class)
        ->shouldReceive('getUnitOfWork')->once()->andReturnUsing(
            static fn () => \Mockery::mock(UnitOfWork::class)
                ->shouldReceive('getEntityPersister')
                ->once()
                ->andReturnUsing(
                    static fn () => \Mockery::mock(EntityPersister::class)
                        ->shouldReceive('loadAll')
                        ->once()
                        ->andReturn([$product])
                        ->getMock()
                )
                ->getMock()
        )->getMock();
        $repository = new ProductRepository($entityManager, new ClassMetadata('product'));

        self::assertSame([$product], $repository->findByIDs(1, 2, 3));
    }
}
