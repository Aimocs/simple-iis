<?php

namespace Aimocs\Iis\Entity;

use Aimocs\Iis\Flat\Database\Entity;

class EmployeeType extends Entity
{

    public function __construct(
        private ?int $id,
        public string $title,
        public string $short_title,
        public \DateTimeImmutable $createdAt
    )
    {
    }


    public static function create(
        string $title,
        string $short_title,
        ?int $id = null,
        ?\DateTimeImmutable $createdAt= null
    )
    {
        return new self($id,$title,$short_title,$createdAt ?? new \DateTimeImmutable());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

}