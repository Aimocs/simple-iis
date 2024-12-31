<?php

namespace Aimocs\Iis\Controller;

use Aimocs\Iis\Entity\CourseTeacher;
use Aimocs\Iis\Entity\Employee;
use Aimocs\Iis\Flat\Controller\AbstractController;
use Aimocs\Iis\Flat\Http\HttpException;
use Aimocs\Iis\Flat\Http\RedirectResponse;
use Aimocs\Iis\Flat\Http\Response;
use Aimocs\Iis\Repo\CourseRepo;
use Aimocs\Iis\Repo\CourseTeacherMapper;
use Aimocs\Iis\Repo\CourseTeacherRepo;
use Aimocs\Iis\Repo\EmployeeRepo;

class CourseTeacherController extends AbstractController
{
    public function __construct(
        private CourseRepo $courseRepo,
        private EmployeeRepo $employeeRepo,
        private CourseTeacherMapper $courseTeacherMapper,
        private CourseTeacherRepo $courseTeacherRepo
    )
    {
    }

    public function index():Response
    {
        if(isset($this->request->getParams['id'])&& !empty($this->request->getParams['id'])){
            $id =$this->request->getParams['id'];
        }else{
            throw new HttpException("Bad Request no QUERY PARAM 'id'. ",404);
        }

        $courses=$this->courseTeacherRepo->getCoursesExceptTeacherId($id);

        return $this->render("pages/course-teacher/add",["title"=>"Add Course to Teacher","courses"=>$courses,"id"=>$id]);
        
    }
    public function store():Response
    {
        $course_id = $this->request->input("course_id");
        $teacher_id = $this->request->input("teacher_id");
        $course = $this->courseRepo->findById($course_id);
        $teacher= $this->employeeRepo->findById($teacher_id);
        $course_teacher = CourseTeacher::create($course,$teacher);
        $this->courseTeacherMapper->save($course_teacher);

        $this->request->getSession()->setFlash("success",sprintf("Teacher %s in COURSE %s ",$teacher->fname." ".$teacher->mname." ".$teacher->lname,$course->name));
        return new RedirectResponse("/add-course-teacher?id={$teacher_id}");

    }

}