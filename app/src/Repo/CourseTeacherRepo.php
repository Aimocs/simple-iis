<?php

namespace Aimocs\Iis\Repo;

use Aimocs\Iis\Entity\Course;
use Aimocs\Iis\Entity\Employee;
use Aimocs\Iis\Flat\Database\Database;

class CourseTeacherRepo
{
    private string $table ="course_teacher";

    public function __construct(
        private Database $database,
        private CategoryRepo $categoryRepo,
        private EmployeeRoleRepo $employeeRoleRepo,
        private EmployeeTypeRepo $employeeTypeRepo
    )
    {
    }


    public function getTeacherByCourseId(int $course_id):?array
    {
        $data= $this->database->CustomQuery("Select * FROM employees WHERE id in (SELECT teacher_id FROM course_teacher WHERE course_id = {$course_id}); ");
        $teachers = [];
        foreach($data as $teacher){
            $empRole = $this->employeeRoleRepo->findById($teacher->employee_role_id);
            $empType = $this->employeeTypeRepo->findById($teacher->employee_type_id);
            $teachers[]= Employee::create($teacher->fname,$teacher->mname,$teacher->lname,$teacher->phone,$teacher->email,new \DateTimeImmutable($teacher->date_of_join),$empType,$empRole,$teacher->id,new \DateTimeImmutable($teacher->created_at));
        }
        return $teachers;
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