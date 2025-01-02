<?php

namespace Aimocs\Iis\Entity;

use Aimocs\Iis\Flat\Database\Entity;

class CourseStudent extends Entity
{
    public function __construct(

        private ?int $id,
        public Course $course,
        public Student $student,
        public ?Group $group,
        public int $price,
        private \DateTimeImmutable $createdAt
    )
    {
    }

    public static function create(
        Course  $course,
        Student $student,
        int $price,
        ?Group $group = null,
        ?int $id = null,
        ?\DateTimeImmutable $createdAt = null
    )
    {
        return new self($id,$course,$student,$group,$price,$createdAt?? new \DateTimeImmutable());
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