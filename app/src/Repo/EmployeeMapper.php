<?php

namespace Aimocs\Iis\Repo;

use Aimocs\Iis\Entity\Employee;
use Aimocs\Iis\Flat\Database\DataMapper;

class EmployeeMapper
{

    private string $table = "employees";

    public function __construct(private DataMapper $dataMapper)
    {
    }

    public function edit(Employee $employee)
    {
        $empRoleId= $employee->employeeRole->getId();
        $empTypeId = $employee->employeeType->getId();
        $dateOfJoin = ($employee->getDateOfJoin())->format('Y-m-d');
        $id = $this->dataMapper->getDatabase()->Update($this->table, [
            "fname"=>$employee->fname,
            "mname"=>$employee->mname,
            "lname"=>$employee->lname,
            "phone"=>$employee->phone,
            "email"=>$employee->email,
            "date_of_join"=>$dateOfJoin,
            "employee_type_id"=>$empTypeId,
            "employee_role_id"=>$empRoleId,
        ],"id",[$employee->getId()]);
        $this->dataMapper->save($employee); // to dispatch postpresist event
    }
    public function save(Employee $employee)
    {
        $empRoleId= $employee->employeeRole->getId();
        $empTypeId = $employee->employeeType->getId();
        $createdAt = ($employee->getCreatedAt())->format('Y-m-d H:i:s');
        $dateOfJoin = ($employee->getDateOfJoin())->format('Y-m-d');
        $id = $this->dataMapper->getDatabase()->Insert($this->table, [
            "fname"=>$employee->fname,
            "mname"=>$employee->mname,
            "lname"=>$employee->lname,
            "phone"=>$employee->phone,
            "email"=>$employee->email,
            "date_of_join"=>$dateOfJoin,
            "employee_type_id"=>$empTypeId,
            "employee_role_id"=>$empRoleId,
            "created_at"=>$createdAt
        ]);
        $this->dataMapper->save($employee); // to dispatch postpresist event
        $employee->setId($id);
    }
}