<?php

namespace Aimocs\Iis\Repo;

use Aimocs\Iis\Entity\Course;
use Aimocs\Iis\Entity\CourseStudent;
use Aimocs\Iis\Flat\Database\Database;

class CourseStudentRepo
{

    private string $table = "course_student";


    public function __construct(
        private Database $database,
        private CategoryRepo $categoryRepo,
        private CourseRepo $courseRepo,
        private StudentRepo $studentRepo,
        private GroupRepo $groupRepo
    )
    {
    }
    public function findByCourseAndStudentIds(int $course_id,int $student_id):?CourseStudent
    {
        $data = $this->database->CustomQuery("SELECT * FROM course_student WHERE course_id ={$course_id} AND student_id={$student_id} ");
        if(empty($data)){
            return null;
        }
        $data = $data[0];
        $course_id = $data->course_id;
        $student_id= $data->student_id;
        $group_id = $data->group_id;
        $course = $this->courseRepo->findById($course_id);
        $student = $this->studentRepo->findById($student_id);
        $group = $group_id===null ? null: $this->groupRepo->findById($group_id);

        $course_student = CourseStudent::create($course,$student,$data->price,$group,$data->id,new \DateTimeImmutable($data->created_at));
        return $course_student;
    }


    public function getCoursesByStudentId(int $student_id):?array
    {
        $data = $this->database->CustomQuery("SELECT * FROM `courses` WHERE id IN ( SELECT course_student.course_id FROM course_student WHERE course_student.student_id = {$student_id} ); ");
        $courses = [];
        foreach($data as $course){
            $category=$this->categoryRepo->findById($course->category_id);
            $courses[]=Course::create($course->name,$course->short_description,$course->price,$category,$course->duration,$course->id,new \DateTimeImmutable($course->created_at));
        }
        return $courses;
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