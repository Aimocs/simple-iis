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

    public function save(CourseStudent $courseStudent)
    {
        $course_id = $courseStudent->course->getId();
        $student_id = $courseStudent->student->getId();
        $createdAt = ($courseStudent->getCreatedAt())->format('Y-m-d H:i:s');
        $id = $this->dataMapper->getDatabase()->Insert($this->table,["course_id"=>$course_id,"student_id"=>$student_id,"price"=>$courseStudent->price,"created_at"=>$createdAt]);
        $courseStudent->setId($id);
    }

}