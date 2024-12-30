<?php

namespace Aimocs\Iis\Controller;

use Aimocs\Iis\Flat\Controller\AbstractController;
use Aimocs\Iis\Flat\Http\RedirectResponse;
use Aimocs\Iis\Flat\Http\Response;
use Aimocs\Iis\Form\Student\DetailFrom;
use Aimocs\Iis\Repo\StudentMapper;
use Aimocs\Iis\Repo\StudentRepo;

class StudentController extends AbstractController
{
    public function __construct(private StudentMapper $studentMapper,private StudentRepo $studentRepo)
    {
    }

    public function index(): Response
    {
        return $this->render("pages/student/add.student",["title"=>"Add Student"]);
    }

    public function showAll(): Response
    {
        $students=$this->studentRepo->getAll();
        return $this->render("pages/student/show.student",["title"=>"Show Students","students"=>$students]);
    }


    public function store(): Response
    {
        $form = new DetailFrom($this->studentMapper);
        $form->setFields(
            name: $this->request->input('name'),
            age: $this->request->input('age'),
            gender: $this->request->input('gender'),
            email: $this->request->input('email'),
            phone: $this->request->input('phone'),
            address: $this->request->input('address'),
            level: $this->request->input('level')
        );
        if($form->hasValidationErrors()){
            foreach($form->getValidationErrors() as $error){
                $this->request->getSession()->setFlash("error", $error);
            }
            return new RedirectResponse("/add-student");
        }
        $student = $form->save();
        $this->request->getSession()->setFlash("success",sprintf("ADDED NEW STUDENT -> %s ",$student->fullname));
        return new RedirectResponse('/add-student');
    }

}