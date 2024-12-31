<?php

namespace Aimocs\Iis\Repo;

use Aimocs\Iis\Entity\Course;
use Aimocs\Iis\Flat\Database\Database;

class CourseStudentRepo
{

    private string $table = "course_student";


    public function __construct(
        private Database $database,
        private CategoryRepo $categoryRepo
    )
    {
    }

    public function getCoursesExceptStudentId(int $student_id):?array
    {
        $data = $this->database->CustomQuery("SELECT * FROM `courses` WHERE id NOT IN ( SELECT course_student.course_id FROM course_student WHERE course_student.student_id = {$student_id} ); ");
        $courses = [];
        foreach($data as $course){
            $category=$this->categoryRepo->findById($course->category_id);
            $courses[]=Course::create($course->name,$course->short_description,$course->price,$category,$course->duration,$course->id,new \DateTimeImmutable($course->created_at));
        }
        return $courses;
    }

}