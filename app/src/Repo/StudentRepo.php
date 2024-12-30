<?php

namespace Aimocs\Iis\Repo;

use Aimocs\Iis\Entity\Student;
use Aimocs\Iis\Flat\Database\Database;

class StudentRepo
{
    private string $table = "students";

    public function __construct(private Database $database )
    {
    }

    public function findById(int $id):?Student
    {
        $data =$this->database->SelectByCriteria($this->table,"*","id",[$id]);
        if (empty($data)){
            return null;
        }
        $student= $data[0];
        $student = Student::create($student->fullname,$student->age,$student->gender,$student->phone,$student->email,$student->address,$student->level,$student->id,new \DateTimeImmutable($student->created_at));
        return $student;
    }

    public function getAll():?array
    {

        $data =$this->database->SelectAll($this->table);
        if (empty($data)){
            return null;
        }

        $students=[];
        foreach($data as $student){
            $students[]= Student::create($student->fullname,$student->age,$student->gender,$student->phone,$student->email,$student->address,$student->level,$student->id,new \DateTimeImmutable($student->created_at));
        }
        return $students;

    }

}