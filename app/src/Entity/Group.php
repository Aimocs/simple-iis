<?php

namespace Aimocs\Iis\Entity;

use Aimocs\Iis\Flat\Database\Entity;

class Group extends Entity
{
    public function __construct(
        private ?int $id,
        public string $name,
        public Course $course,
        public Employee $teacher,
        public \DateTimeImmutable $start_datetime,
        public ?int $capacity,
        private \DateTimeImmutable $createdAt
    )
    {
    }

    public static function create(
        string $name,
        Course $course,
        Employee $employee,
        \DateTimeImmutable $start_datetime,
        ?int $capacity = null,
        ?int $id = null,
        ?\DateTimeImmutable $createdAt = null
    ):Group
    {
        return new self(
            $id,
            $name,
            $course,
            $employee,
            $start_datetime,
            $capacity,
            $createdAt?? new \DateTimeImmutable()
        );
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