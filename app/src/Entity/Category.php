<?php

namespace Aimocs\Iis\Entity;

use Aimocs\Iis\Flat\Database\Entity;

class Category extends Entity
{
    public function __construct(
        private ?int $id,
        public string $name,
        public string $description,
        private \DateTimeImmutable $createdAt
    )
    {
    }

    public static function create(
        string $name,
        string $description,
        ?int $id = null,
        ?\DateTimeImmutable $createAt = null
    )
    {
        return new self($id,$name,$description,$createAt?? new \DateTimeImmutable());
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

}