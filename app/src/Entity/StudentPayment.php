<?php

namespace Aimocs\Iis\Entity;

use Aimocs\Iis\Flat\Database\Entity;
use Aimocs\Iis\Repo\CourseStudentRepo;

class StudentPayment extends Entity
{

    public function __construct(
        private ?int $id,
        public CourseStudent $courseStudent,
        public int $amount,
        public string $remark,
        private \DateTimeImmutable $createdAt
    )
    {

    }


    public static function create(
        CourseStudent $courseStudent,
        int $amount,
        string $remark,
        ?int $id = null,
        ?\DateTimeImmutable $createdAt=null

    )
    {
        return new self($id,$courseStudent,$amount,$remark,$createdAt??new \DateTimeImmutable());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}