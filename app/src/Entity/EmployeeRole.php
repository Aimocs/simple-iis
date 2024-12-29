<?php

namespace Aimocs\Iis\Entity;

use Aimocs\Iis\Flat\Database\Entity;

class EmployeeRole extends Entity
{
    public function __construct(

        private ?int $id,
        public string $title,
        public \DateTimeImmutable $createdAt
    )
    {
    }

    public static function create(
        string $title,
        ?int $id = null,
        ?\DateTimeImmutable $createdAt= null
    )
    {
        return new self($id,$title,$createdAt ?? new \DateTimeImmutable());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

}