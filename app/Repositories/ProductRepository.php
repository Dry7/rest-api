<?php

declare(strict_types=1);

namespace App\Repositories;

class ProductRepository extends \Doctrine\ORM\EntityRepository
{
    public function findByIDs(...$ids)
    {
        return $this->findBy(['id' => $ids]);
    }
}
