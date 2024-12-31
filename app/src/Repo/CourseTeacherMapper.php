<?php

namespace Aimocs\Iis\Repo;

use Aimocs\Iis\Entity\CourseTeacher;
use Aimocs\Iis\Flat\Database\DataMapper;

class CourseTeacherMapper
{
    private string $table = "course_teacher";
    public function __construct(
        private DataMapper $dataMapper
    )
    {
    }

    public function save(CourseTeacher $courseTeacher)
    {
        $course_id=$courseTeacher->course->getId();
        $teacher_id=$courseTeacher->teacher->getId();
        $created_at=($courseTeacher->getCreatedAt())->format('Y-m-d H:i:s');
        $id= $this->dataMapper->getDatabase()->Insert($this->table,["course_id"=>$course_id,"teacher_id"=>$teacher_id,"created_at"=>$created_at]);
        $courseTeacher->setId($id);
    }

}