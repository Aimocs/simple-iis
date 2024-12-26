<?php

namespace Aimocs\Iis\Entity;

use Aimocs\Iis\Flat\Database\Entity;

class Student extends Entity
{
    public function __construct(
        private ?int $id,
        public string $fname,
        public string $mname,
        public string $lname,
        public string $phone,
        public string $email,
        private \DateTimeImmutable $createdAt
    )
    {

    }

    public static function create(
        string $fname,
        string $mname,
        string $lname,
        string $phone,
        string $email,
        ?int $id = null,
        ?\DateTimeImmutable $createdAt = null,
    )
    {
        return new self($id, $fname,$mname, $lname,$phone,$email ,$createdAt ?? new \DateTimeImmutable());
    }


}