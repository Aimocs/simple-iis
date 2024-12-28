<?php

namespace Aimocs\Iis\Entity;

use Aimocs\Iis\Flat\Database\Entity;

class Course extends Entity
{
    public function __construct(
        private ?int $id,
        public string $name,
        public string $short_description,
        public int $price,
        public Category $category,
        public string $duration,
        private \DateTimeImmutable $createdAt
    )
    {
    }

    public static function create(
        string $name,
        string $short_description,
        int $price,
        Category $category,
        string $duration,
        ?int $id = null,
        ?\DateTimeImmutable $createdAt = null
    )
    {
        return new self($id,$name,$short_description,$price,$category,$duration,$createdAt ?? new \DateTimeImmutable());
    }

    public function getCategoryName():string
    {
        return $this->category->name;
    }

    public function getCategoryId():int
    {
        return $this->category->getId();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

}