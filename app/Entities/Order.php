<?php

declare(strict_types=1);

namespace App\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @Entity(repositoryClass="App\Repositories\OrderRepository")
 * @Table(name="orders")
 */
class Order
{
    public const STATUS_NEW = 0;
    public const STATUS_PAID = 1;

    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="SEQUENCE")
     * @SequenceGenerator(sequenceName="orders_seq", initialValue=1)
     */
    private int $id;

    /** @Column(type="smallint", options={"default":0}) */
    private int $status = self::STATUS_NEW;

    /**
     * @ManyToMany(targetEntity="Product", inversedBy="orders")
     * @JoinTable(name="orders_products")
     */
    private Collection $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id ?? null;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    public function products(): Collection
    {
        return $this->products;
    }

    public static function createFromProducts(array $products): self
    {
        $order = new self();

        foreach ($products as $product) {
            $order->products()->add($product);
        }

        return $order;
    }
}
