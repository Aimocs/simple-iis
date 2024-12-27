<?php

namespace Aimocs\Iis\Repo;

use Aimocs\Iis\Entity\Student;
use Aimocs\Iis\Flat\Database\DataMapper;

class StudentMapper
{
    private string $table = 'students';

    public function __construct(private DataMapper $dataMapper)
    {
    }

    public function save(Student $student)
    {
        $createdAt= ( $student->getCreatedAt() )->format('Y-m-d H:i:s');
        $id = $this->dataMapper->getDatabase()->Insert($this->table,['fullname'=>$student->fullname,'age'=>$student->age,'phone'=>$student->phone,'gender'=>$student->gender,'email'=>$student->email,'address'=>$student->address,'level'=>$student->level,'created_at'=>$createdAt]);
        $this->dataMapper->save($student);
        $student->setId($id);
    }
}