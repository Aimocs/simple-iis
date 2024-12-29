<?php

namespace Aimocs\Iis\Entity;

use Aimocs\Iis\Flat\Database\Entity;

class Employee extends Entity
{

    public function __construct(
        private ?int $id,
        public string $fname,
        public string $mname,
        public string $lname,
        public string $phone,
        public string $email,
        private \DateTimeImmutable $dateOfJoin,
        public EmployeeType $employeeType,
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
        \DateTimeImmutable $dateOfJoin,
        EmployeeType $employeeType,
        ?int $id = null,
        ?\DateTimeImmutable $createdAt= null,
    )
    {

        return new self(
            $id,
            $fname,
            $mname,
            $lname,
            $phone,
            $email,
            $dateOfJoin,
            $employeeType,
            $createdAt?? new \DateTimeImmutable()
        );

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getDateOfJoin(): \DateTimeImmutable
    {
        return $this->dateOfJoin;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

}