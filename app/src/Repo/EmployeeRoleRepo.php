<?php

namespace Aimocs\Iis\Repo;

use Aimocs\Iis\Entity\EmployeeRole;
use Aimocs\Iis\Flat\Database\Database;

class EmployeeRoleRepo
{

    private string $table = "employee_roles";
    public function __construct(private Database $database)
    {
    }

    public function findById(int $id): ?EmployeeRole
    {
        $data =$this->database->SelectByCriteria($this->table,"*","id",[$id]);
        if (empty($data)){
            return null;
        }
        $data = $data[0];
        $empRole = EmployeeRole::create($data->title,$data->id,new \DateTimeImmutable($data->created_at) );
        return $empRole;
    }

    public function getAll(): ?array
    {
        $data =$this->database->SelectAll($this->table);
        if (empty($data)){
            return null;
        }

        $employeeRoles=[];
        foreach($data as $empType){
            $employeeRoles[]= EmployeeRole::create(
                $empType->title,
                $empType->id,
                new \DateTimeImmutable($empType->created_at)
            );
        }
        return $employeeRoles;
    }
}
