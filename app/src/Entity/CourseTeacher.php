<?php

namespace Aimocs\Iis\Entity;

use Aimocs\Iis\Flat\Database\Entity;

class CourseTeacher extends Entity
{
    public function __construct(
        private ?int $id,
        public Course $course,
        public Employee $teacher,
        private \DateTimeImmutable $createdAt
    )
    {
    }

    public static function create(
        Course $course,
        Employee $teacher,
        ?int $id = null,
        ?\DateTimeImmutable $createdAt=null
    )
    {
        return new self($id,$course,$teacher,$createdAt?? new \DateTimeImmutable());
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