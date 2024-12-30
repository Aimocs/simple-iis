<?php

namespace Aimocs\Iis\Controller;

use Aimocs\Iis\Entity\CourseStudent;
use Aimocs\Iis\Entity\Student;
use Aimocs\Iis\Flat\Controller\AbstractController;
use Aimocs\Iis\Flat\Http\HttpException;
use Aimocs\Iis\Flat\Http\RedirectResponse;
use Aimocs\Iis\Flat\Http\Response;
use Aimocs\Iis\Repo\CourseRepo;
use Aimocs\Iis\Repo\CourseStudentMapper;
use Aimocs\Iis\Repo\StudentRepo;

class CourseStudentController extends  AbstractController
{
    public function __construct(
        private CourseRepo $courseRepo,
        private StudentRepo $studentRepo,
        private CourseStudentMapper $courseStudentMapper
    )
    {
    }

    public function index():Response
    {
        if(isset($this->request->getParams['id'])&& !empty($this->request->getParams['id'])){
            $id =$this->request->getParams['id'];
        }else{
            throw new HttpException("Bad Request",404);
        }
        $courses=$this->courseRepo->getAll();
        return $this->render("pages/course-student/add",["title"=>"Add course to student","courses"=>$courses,"id"=>$id]);
    }

    public function store():Response
    {
        $student_id=$this->request->input('student_id');
        $course_id=$this->request->input('course_id');
        $price = $this->request->input('price');
        $student = $this->studentRepo->findById($student_id);
        $course = $this->courseRepo->findById($course_id);
        $course_student=CourseStudent::create($course,$student,$price);
        $this->courseStudentMapper->save($course_student);

        $this->request->getSession()->setFlash("success",sprintf("STUDENT %s in COURSE %s ",$student->fullname,$course->name));
        return new RedirectResponse("/add-course-student?id={$student_id}");

    }
}