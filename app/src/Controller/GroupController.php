<?php

namespace Aimocs\Iis\Controller;

use Aimocs\Iis\Flat\Controller\AbstractController;
use Aimocs\Iis\Flat\Http\RedirectResponse;
use Aimocs\Iis\Flat\Http\Response;
use Aimocs\Iis\Form\Group\GroupForm;
use Aimocs\Iis\Repo\CourseRepo;
use Aimocs\Iis\Repo\CourseTeacherRepo;
use Aimocs\Iis\Repo\EmployeeRepo;
use Aimocs\Iis\Repo\GroupMapper;
use Aimocs\Iis\Repo\GroupRepo;

class GroupController extends  AbstractController
{
    public function __construct(
        private CourseRepo $courseRepo,
        private EmployeeRepo $teacherRepo,
        private GroupMapper $groupMapper,
        private CourseTeacherRepo $courseTeacherRepo,
        private GroupRepo $groupRepo
    )
    {
    }

    public function index():Response
    {
        $courses = $this->courseRepo->getAll();
        return $this->render("pages/group/add.group",["title"=>"Add Group","courses"=>$courses]);
    }

    public function showAll():Response
    {
        $groups = $this->groupRepo->getAll();
        return $this->render("pages/group/show.group",["title"=>"Show Groups","groups"=>$groups]);
    }
    public function store():Response
    {
        $course_id = $this->request->input("course_id");
        $teacher_id = $this->request->input("teacher_id");
        $name = $this->request->input("name");
        $start_datetime = $this->request->input("start_datetime");
        $capacity = $this->request->input("capacity");
        $capacity = empty($capacity) ? null : $capacity;
        $form = new GroupForm($this->groupMapper,$this->courseRepo,$this->teacherRepo);
        $form->setFields(
            $name,
            $course_id,
            $teacher_id,
            new \DateTimeImmutable($start_datetime),
            $capacity
        );
        if($form->hasValidationErrors()){
            foreach($form->getValidationErrors() as $error){
                $this->request->getSession()->setFlash("error", $error);
            }
            return new RedirectResponse("/add-student");
        }
        $group =$form->save();
        $teacher = $this->teacherRepo->findById($teacher_id);
        $course = $this->courseRepo->findById($course_id);
        $this->request->getSession()->setFlash("success",sprintf("Created NEW Group -> %s Course -> %s, Teacher -> %s",$name,$course->name,$teacher->fname . " ".$teacher->mname." ".$teacher->lname));
        return new RedirectResponse('/add-group');

    }
    public function getTeacher(int $course_id):Response
    {
        $response =  new Response();
        // maybe i should create a api function in abstract controller something like the render function that will build response
        $response->setHeader("Content-Type","application/json");
        $teachers = $this->courseTeacherRepo->getTeacherByCourseId($course_id);
        $teacherData = array_map(function($teacher) {
            return [
                'id' => $teacher->getId(), // Assuming getId() retrieves the teacher ID
                'full_name' => trim($teacher->fname . ' ' . $teacher->mname . ' ' . $teacher->lname) // Concatenate first, middle, and last names
            ];
        }, $teachers);
        $response->setContent(json_encode($teacherData));
        return $response;
    }

    public function edit_page(int $group_id): Response
    {
        $group = $this->groupRepo->findById($group_id);
        $courses = $this->courseRepo->getAll();
        return $this->render("pages/group/edit.group",["title"=>"Edit Group","courses"=>$courses,"group"=>$group]);
    }

    public function edit():Response
    {
        $id = $this->request->input("id");
        $course_id = $this->request->input("course_id");
        $teacher_id = $this->request->input("teacher_id");
        $name = $this->request->input("name");
        $start_datetime = $this->request->input("start_datetime");
        $capacity = $this->request->input("capacity");
        $capacity = empty($capacity) ? null : $capacity;
        $form = new GroupForm($this->groupMapper,$this->courseRepo,$this->teacherRepo);
        $form->setFields(
            $name,
            $course_id,
            $teacher_id,
            new \DateTimeImmutable($start_datetime),
            $capacity
        );
        if($form->hasValidationErrors()){
            foreach($form->getValidationErrors() as $error){
                $this->request->getSession()->setFlash("error", $error);
            }
            return new RedirectResponse("/edit-group/{$this->request->input("id")}");
        }
        $group =$form->edit($id);
        $teacher = $this->teacherRepo->findById($teacher_id);
        $course = $this->courseRepo->findById($course_id);
        $this->request->getSession()->setFlash("success",sprintf("Edited  Group -> %s Course -> %s, Teacher -> %s",$name,$course->name,$teacher->fname . " ".$teacher->mname." ".$teacher->lname));
        return new RedirectResponse('/show-groups');

    }

}