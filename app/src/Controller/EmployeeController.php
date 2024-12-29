<?php

namespace Aimocs\Iis\Controller;

use Aimocs\Iis\Flat\Controller\AbstractController;
use Aimocs\Iis\Flat\Http\RedirectResponse;
use Aimocs\Iis\Flat\Http\Response;
use Aimocs\Iis\Form\Employee\EmployeeForm;
use Aimocs\Iis\Repo\EmployeeMapper;
use Aimocs\Iis\Repo\EmployeeTypeRepo;

class EmployeeController extends AbstractController
{
    public function __construct(
        private EmployeeTypeRepo $employeeTypeRepo,
        private EmployeeMapper $employeeMapper
    )
    {
    }

    public function index(): Response
    {
        $employeeTypes = $this->employeeTypeRepo->getAll();

        return $this->render('pages/employee/add.employee',[
            "title"=>"Add Employee",
            "employeeTypes"=>$employeeTypes
        ]);
    }

    public function store(): Response
    {

        $form = new EmployeeForm($this->employeeMapper,$this->employeeTypeRepo);
        $form->setFields(
            $this->request->input('fname'),
            $this->request->input('mname'),
            $this->request->input('lname'),
            $this->request->input('phone'),
            $this->request->input('email'),
            $this->request->input('employeeType'),
            $this->request->input('dateOfJoin'),
        );
        if($form->hasValidationErrors()){
            foreach($form->getValidationErrors() as $error){
                $this->request->getSession()->setFlash("error", $error);
            }
            return new RedirectResponse("/add-employee");
        }
        $employee = $form->save();
        $this->request->getSession()->setFlash("success",sprintf("NEW EMPLOYEE ADDED!!! %s %s ",$employee->fname,$employee->lname));
        return new RedirectResponse('/add-employee');

        
    }
}