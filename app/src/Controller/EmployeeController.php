<?php

namespace Aimocs\Iis\Controller;

use Aimocs\Iis\Entity\EmployeeRole;
use Aimocs\Iis\Flat\Controller\AbstractController;
use Aimocs\Iis\Flat\Http\RedirectResponse;
use Aimocs\Iis\Flat\Http\Response;
use Aimocs\Iis\Form\Employee\EmployeeForm;
use Aimocs\Iis\Repo\EmployeeMapper;
use Aimocs\Iis\Repo\EmployeeRepo;
use Aimocs\Iis\Repo\EmployeeRoleMapper;
use Aimocs\Iis\Repo\EmployeeRoleRepo;
use Aimocs\Iis\Repo\EmployeeTypeRepo;

class EmployeeController extends AbstractController
{
    public function __construct(
        private EmployeeTypeRepo $employeeTypeRepo,
        private EmployeeMapper $employeeMapper,
        private EmployeeRoleMapper $employeeRoleMapper,
        private EmployeeRoleRepo $employeeRoleRepo,
        private EmployeeRepo $employeeRepo
    )
    {
    }

    public function showAll():Response
    {

        $employees= $this->employeeRepo->getAll();
        return $this->render("pages/employee/show.employee",["title"=>"Show Employees","employees"=>$employees]);
    }
    public function index(): Response
    {
        $employeeTypes = $this->employeeTypeRepo->getAll();
        $employeeRoles = $this->employeeRoleRepo->getAll();

        return $this->render('pages/employee/add.employee',[
            "title"=>"Add Employee",
            "employeeTypes"=>$employeeTypes,
            "employeeRoles"=>$employeeRoles
        ]);
    }

    public function edit_page(int $employee_id):Response
    {
        $employeeTypes = $this->employeeTypeRepo->getAll();
        $employeeRoles = $this->employeeRoleRepo->getAll();

        $employee = $this->employeeRepo->findById($employee_id);
        return $this->render('pages/employee/edit.employee',[
            "title"=>"Edit Employee",
            "employeeTypes"=>$employeeTypes,
            "employeeRoles"=>$employeeRoles,
            "employee"=>$employee
        ]);

    }

    public function edit():Response
    {

        $form = new EmployeeForm($this->employeeMapper,$this->employeeTypeRepo,$this->employeeRoleRepo);
        $form->setFields(
            $this->request->input('fname'),
            $this->request->input('mname'),
            $this->request->input('lname'),
            $this->request->input('phone'),
            $this->request->input('email'),
            $this->request->input('employeeType'),
            $this->request->input('dateOfJoin'),
            $this->request->input('employeeRole')
        );
        if($form->hasValidationErrors()){
            foreach($form->getValidationErrors() as $error){
                $this->request->getSession()->setFlash("error", $error);
            }
            return new RedirectResponse("/edit-employee/{$this->request->input("id")}");
        }
        $employee = $form->edit($this->request->input("id"));
        $this->request->getSession()->setFlash("success",sprintf("Edited EMPLOYEE Successfully!!! "));
        return new RedirectResponse('/show-employees');
    }
    public function store(): Response
    {

        $form = new EmployeeForm($this->employeeMapper,$this->employeeTypeRepo,$this->employeeRoleRepo);
        $form->setFields(
            $this->request->input('fname'),
            $this->request->input('mname'),
            $this->request->input('lname'),
            $this->request->input('phone'),
            $this->request->input('email'),
            $this->request->input('employeeType'),
            $this->request->input('dateOfJoin'),
            $this->request->input('employeeRole')
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

    public function role_index():Response
    {
       return $this->render('pages/employee/add.role.employee',["title"=>"Add Employee Role"]);
    }

    public function role_store():Response
    {
        $title = $this->request->input("title");
        $empRole = EmployeeRole::create(
            $title
        );
        $this->employeeRoleMapper->save($empRole);
        $this->request->getSession()->setFlash("success",sprintf("NEW Employee ROLE ADDED!!! %s",$empRole->title));
        return new RedirectResponse('/add-role-employee');
    }

    public function role_showAll():Response
    {
        $employeeRoles=$this->employeeRoleRepo->getAll();
        return $this->render("pages/employee/show.role.employee",["title"=>"Show Employee Roles","employeeRoles"=>$employeeRoles]);
        
    }
}