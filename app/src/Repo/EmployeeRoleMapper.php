<?php

namespace Aimocs\Iis\Repo;

use Aimocs\Iis\Entity\EmployeeRole;
use Aimocs\Iis\Flat\Database\DataMapper;

class EmployeeRoleMapper
{
    private string $table = "employee_roles";

    public function __construct(private DataMapper $dataMapper)
    {
    }

    public function save(EmployeeRole $empRole)
    {
        $title = $empRole->title;
        $createdAt = ($empRole->createdAt)->format('Y-m-d H:i:s');
        $id = $this->dataMapper->getDatabase()->Insert($this->table,["title"=>$title,"created_at"=>$createdAt]);
        $this->dataMapper->save($empRole);
        $empRole->setId($id);
    }

}