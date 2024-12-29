<?php

namespace Aimocs\Iis\Repo;

use Aimocs\Iis\Entity\EmployeeType;
use Aimocs\Iis\Flat\Database\Database;

// this repo retrives static employee types which i have defined in the database

class EmployeeTypeRepo
{
    private string $table = "employee_types";
    public function __construct(private Database $database)
    {
    }

    public function findById(int $id): ?EmployeeType
    {
        $data =$this->database->SelectByCriteria($this->table,"*","id",[$id]);
        if (empty($data)){
            return null;
        }
        $data = $data[0];
        $empType = EmployeeType::create($data->title,$data->short_title,$data->id,new \DateTimeImmutable($data->created_at) );
        return $empType;
    }

    public function getAll(): ?array
    {
        $data =$this->database->SelectAll($this->table);
        if (empty($data)){
            return null;
        }

        $employeeTypes=[];
        foreach($data as $empType){
            $employeeTypes[]= EmployeeType::create(
                $empType->title,
                $empType->short_title,
                $empType->id,
                new \DateTimeImmutable($empType->created_at)
            );
        }
        return $employeeTypes;
    }
}