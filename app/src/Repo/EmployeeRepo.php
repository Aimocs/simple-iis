<?php

namespace Aimocs\Iis\Repo;

use Aimocs\Iis\Entity\Employee;
use Aimocs\Iis\Flat\Database\Database;

class EmployeeRepo
{
    private string $table="employees";

    public function __construct(
        private Database $database,
        private EmployeeRoleRepo $employeeRoleRepo,
        private EmployeeTypeRepo $employeeTypeRepo
    )
    {
    }

    public function getAll(): ? array
    {

        $data= $this->database->SelectAll($this->table);
        if (empty($data)){
            return null;
        }
        $employees=[];
        foreach($data as $employee){
            $employeeRole=$this->employeeRoleRepo->findById($employee->employee_role_id);
            $employeeType=$this->employeeTypeRepo->findById($employee->employee_type_id);
            $employees[]=Employee::create($employee->fname,$employee->mname,$employee->lname,$employee->phone,$employee->email,new \DateTimeImmutable($employee->date_of_join),$employeeType,$employeeRole,$employee->id,new \DateTimeImmutable($employee->created_at));
        }
        return $employees;
    }

}