<?php

declare(strict_types=1);

namespace App\Repositories;

use Doctrine\ORM\EntityRepository;

class ProductRepository extends EntityRepository
{
    public function findByIDs(...$ids)
    {
        return $this->findBy(['id' => $ids]);
    }
}
