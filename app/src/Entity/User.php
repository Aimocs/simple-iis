<?php

namespace Aimocs\Iis\Entity;

use Aimocs\Iis\Flat\Authentication\AuthUserInterface;
use Aimocs\Iis\Flat\Database\Entity;

class User extends Entity implements AuthUserInterface
{

    public function __construct(
        private ?int $id,
        public string $username,
        private string $password,
        private \DateTimeImmutable $createdAt

    )
    {
    }


    public static function create(string $username, string $plainPassword):self
    {
       return new self(
           null,
           $username,
           password_hash($plainPassword, PASSWORD_DEFAULT),
           new \DateTimeImmutable()
       );
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getAuthId(): int|string
    {
        return $this->id;
    }
}