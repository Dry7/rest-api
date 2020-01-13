<?php

declare(strict_types=1);

namespace App\Entities;

/**
 * @Entity
 * @Table(name="orders")
 */
class Order
{
    private const STATUS_NEW = 0;
    private const STATUS_PAID = 1;

    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="SEQUENCE")
     * @SequenceGenerator(sequenceName="orders_seq", initialValue=1)
     */
    private int $id;

    /** @Column */
    private string $name;

    /** @Column(type="smallint", options={"default":0}) */
    private int $status = self::STATUS_NEW;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): void
    {
        $this->status = $status;
    }
}
