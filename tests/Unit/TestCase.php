<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Entities\Product;
use App\Request;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use PHPUnit\Framework\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected Request $request;
    protected EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = \Mockery::mock(Request::class);
        $this->entityManager = \Mockery::mock(EntityManagerInterface::class);
    }

    protected function mockJsonContent($return): void
    {
        $this->request
            ->shouldReceive('jsonContent')
            ->andReturn($return)
            ->once()
            ->getMock();
    }

    protected function mockFindByIDs(array $with, array $return): void
    {
        $this->entityManager
            ->shouldReceive('getRepository')
            ->with(Product::class)
            ->once()
            ->andReturnUsing(
                static fn () => \Mockery::mock(ObjectRepository::class)
                    ->shouldReceive('findByIDs')
                    ->with(...$with)
                    ->once()
                    ->andReturn($return)
                    ->getMock()
            )
            ->getMock();
    }

    protected function mockRepositoryFind(string $class, int $id, $return): void
    {
        $this->entityManager
            ->shouldReceive('getRepository')
            ->with($class)
            ->once()
            ->andReturnUsing(
                static fn () => \Mockery::mock(ObjectRepository::class)
                    ->shouldReceive('find')
                    ->with($id)
                    ->once()
                    ->andReturn($return)
                    ->getMock()
            )
            ->getMock();
    }
}
