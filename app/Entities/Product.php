<?php

declare(strict_types=1);

namespace App\Entities;

/**
 * @Entity(repositoryClass="App\Repositories\ProductRepository")
 * @Table(name="products")
*/
class Product
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="SEQUENCE")
     * @SequenceGenerator(sequenceName="products_seq", initialValue=1)
     */
    private int $id;

    /** @Column */
    private string $name;

    /** @Column(type="decimal", precision=10, scale=2) */
    private float $price;

    public function __construct(string $name, float $price)
    {
        $this->setName($name);
        $this->setPrice($price);
    }

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

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id ?? null,
            'name' => $this->name,
            'price' => $this->price,
        ];
    }
}
