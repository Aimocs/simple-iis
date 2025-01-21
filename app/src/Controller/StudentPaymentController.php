<?php

namespace Aimocs\Iis\Controller;

use Aimocs\Iis\Entity\StudentPayment;
use Aimocs\Iis\Flat\Controller\AbstractController;
use Aimocs\Iis\Flat\Http\HttpException;
use Aimocs\Iis\Flat\Http\RedirectResponse;
use Aimocs\Iis\Flat\Http\Response;
use Aimocs\Iis\Repo\CourseStudentRepo;
use Aimocs\Iis\Repo\StudentPaymentMapper;
use Aimocs\Iis\Repo\StudentPaymentRepo;

class StudentPaymentController extends AbstractController
{
    public function __construct(
        private CourseStudentRepo $courseStudentRepo,
        private StudentPaymentMapper $studentPaymentMapper,
        private StudentPaymentRepo $studentPaymentRepo
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
        $courses=$this->courseStudentRepo->getCoursesByStudentId($id);

        return $this->render("pages/student-payment/add",["title"=>"Add Installment","courses"=>$courses,"id"=>$id]);
    }

    public function show(int $student_id):Response
    {
        $courses_students = $this->courseStudentRepo->getCourseStudentsByStudentId($student_id);
        $payments = [];
        foreach($courses_students as $courses_student ){
            $course = $courses_student->course;
            $payments["{$course->name}"] = $this->studentPaymentRepo->getPaymentsByStudentId($courses_student->getId());
        }
        $payments = array_filter($payments);

        return $this->render("pages/student-payment/show",["title"=>"Show Payment Details","payments"=>$payments,"id"=>$student_id]);

    }

    public function store():Response
    {
        $student_id=$this->request->input('student_id');
        $course_id=$this->request->input('course_id');
        $remarks=$this->request->input('remark');
        $amount= $this->request->input('amount');

        $course_student = $this->courseStudentRepo->findByCourseAndStudentIds($course_id,$student_id);
        $student_payment = StudentPayment::create($course_student,$amount,$remarks);
        $this->studentPaymentMapper->save($student_payment);

        $this->request->getSession()->setFlash("success",sprintf("Student %s in Payment Added %d ",$course_student->student->fullname,$amount));
        return new RedirectResponse("/add-student-payment?id={$student_id}");
    }



}