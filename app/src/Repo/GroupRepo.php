<?php

namespace Aimocs\Iis\Repo;

use Aimocs\Iis\Entity\Group;
use Aimocs\Iis\Flat\Database\Database;

class GroupRepo
{
    private string $table = "groups";


    public function __construct(
        private Database $database,
        private CourseRepo $courseRepo,
        private EmployeeRepo $teacherRepo
    )
    {
    }

    public function findById(int $id):?Group
    {
        $data =$this->database->SelectByCriteria($this->table,"*","id",[$id]);
        if (empty($data)){
            return null;
        }
        $group = $data[0];
        $course = $this->courseRepo->findById($group->course_id);
        $teacher = $this->teacherRepo->findById($group->teacher_id);
        $group = Group::create($group->name,$course,$teacher,new \DateTimeImmutable($group->start_datetime),$group->capacity,$group->id,new \DateTimeImmutable($group->created_at));
        return $group;
    }

    public function getAll():?array
    {
        $data =$this->database->SelectAll($this->table);
        if (empty($data)){
            return null;
        }
        $groups=[];
        foreach($data as $group){
            $course = $this->courseRepo->findById($group->course_id);
            $teacher = $this->teacherRepo->findById($group->teacher_id);
            $groups[]= Group::create($group->name,$course,$teacher,new \DateTimeImmutable($group->start_datetime),$group->capacity,$group->id,new \DateTimeImmutable($group->created_at));
        }
        return $groups;
    }

    public function getGroupsValidByCourseId(int $course_id):?array
    {
        $data =$this->database->CustomQuery("SELECT * FROM `{$this->table}` WHERE course_id = '{$course_id}' ");
        if (empty($data)){
            return null;
        }
        $groups=[];
        foreach($data as $group){
            $course = $this->courseRepo->findById($group->course_id);
            $teacher = $this->teacherRepo->findById($group->teacher_id);
            $groups[]= Group::create($group->name,$course,$teacher,new \DateTimeImmutable($group->start_datetime),$group->capacity,$group->id,new \DateTimeImmutable($group->created_at));
        }
        return $groups;
    }
}