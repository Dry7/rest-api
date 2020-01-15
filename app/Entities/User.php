<?php

declare(strict_types=1);

namespace App\Entities;

class User
{
    private const DEFAULT_USER = [
        'id' => 1,
        'login' => 'admin'
    ];
    private int $id;
    private string $login;

    public function __construct(?int $id = null, ?string $login = null)
    {
        $this->setId($id ?? self::DEFAULT_USER['id']);
        $this->setLogin($login ?? self::DEFAULT_USER['login']);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @param string $login
     */
    public function setLogin(string $login): void
    {
        $this->login = $login;
    }
}
