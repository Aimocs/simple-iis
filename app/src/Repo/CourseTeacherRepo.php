<?php

namespace Aimocs\Iis\Repo;

use Aimocs\Iis\Entity\Course;
use Aimocs\Iis\Flat\Database\Database;

class CourseTeacherRepo
{
    private string $table ="course_teacher";

    public function __construct(
        private Database $database,
        private CategoryRepo $categoryRepo
    )
    {
    }


    public function getCoursesExceptTeacherId(int $teacher_id):?array
    {
        $data = $this->database->CustomQuery("SELECT * FROM `courses` WHERE id NOT IN ( SELECT course_teacher.course_id FROM course_teacher WHERE course_teacher.teacher_id = {$teacher_id} ); ");
        $courses = [];
        foreach($data as $course){
            $category=$this->categoryRepo->findById($course->category_id);
            $courses[]=Course::create($course->name,$course->short_description,$course->price,$category,$course->duration,$course->id,new \DateTimeImmutable($course->created_at));
        }
        return $courses;
    }

}