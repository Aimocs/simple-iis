<?php

namespace Aimocs\Iis\Repo;

use Aimocs\Iis\Entity\CourseStudent;
use Aimocs\Iis\Flat\Database\DataMapper;

class CourseStudentMapper
{
    private string $table = "course_student";
    public function __construct(private DataMapper $dataMapper)
    {
    }

    public function edit(CourseStudent $courseStudent)
    {
        $cs_id = $courseStudent->getId();
        $course_id = $courseStudent->course->getId();
        $student_id = $courseStudent->student->getId();
        $group_id = $courseStudent->group?->getId();
        $createdAt = ($courseStudent->getCreatedAt())->format('Y-m-d H:i:s');
        $id = $this->dataMapper->getDatabase()->Update($this->table,["course_id"=>$course_id,"student_id"=>$student_id,"price"=>$courseStudent->price,"group_id"=>$group_id,"created_at"=>$createdAt],"id",[$cs_id]);
    }
    public function save(CourseStudent $courseStudent)
    {
        $course_id = $courseStudent->course->getId();
        $student_id = $courseStudent->student->getId();
        $createdAt = ($courseStudent->getCreatedAt())->format('Y-m-d H:i:s');
        $id = $this->dataMapper->getDatabase()->Insert($this->table,["course_id"=>$course_id,"student_id"=>$student_id,"price"=>$courseStudent->price,"created_at"=>$createdAt]);
        $courseStudent->setId($id);
    }

}