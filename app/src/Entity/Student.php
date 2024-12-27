<?php

namespace Aimocs\Iis\Entity;

use Aimocs\Iis\Flat\Database\Entity;

class Student extends Entity
{
    public function __construct(
        private ?int $id,
        public string $fullname,
        public int $age,
        public string $gender,
        public string $phone,
        public string $email,
        public string $address,
        public string $level,
        private \DateTimeImmutable $createdAt
    )
    {

    }

    public static function create(
        string $fullname,
        int $age,
        string $gender,
        string $phone,
        string $email,
        string $address,
        string $level,
        ?int $id = null,
        ?\DateTimeImmutable $createdAt = null,
    )
    {
        return new self($id,$fullname,$age,$gender,$phone,$email ,$address,$level,$createdAt ?? new \DateTimeImmutable());
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