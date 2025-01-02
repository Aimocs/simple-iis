<?php

namespace Aimocs\Iis\Controller;

use Aimocs\Iis\Entity\CourseStudent;
use Aimocs\Iis\Flat\Controller\AbstractController;
use Aimocs\Iis\Flat\Http\HttpException;
use Aimocs\Iis\Flat\Http\RedirectResponse;
use Aimocs\Iis\Flat\Http\Response;
use Aimocs\Iis\Repo\CourseStudentMapper;
use Aimocs\Iis\Repo\CourseStudentRepo;
use Aimocs\Iis\Repo\GroupRepo;

class StudentGroupController extends AbstractController
{
    public function __construct(
        private GroupRepo $groupRepo,
        private CourseStudentRepo $courseStudentRepo,
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
        $courses= $this->courseStudentRepo->getCoursesByStudentId($id);
        return $this->render("pages/student-group/add",["title"=>"Add Student to Group","courses"=>$courses,"id"=>$id]);
    }

    public function edit():Response
    {
        $student_id = $this->request->input("student_id");
        $group_id = $this->request->input("group_id");
        $course_id = $this->request->input("course_id");
        $group = $this->groupRepo->findById($group_id);
        if($group !==null){
            $courseStudent =$this->courseStudentRepo->findByCourseAndStudentIds($course_id,$student_id);
        }else{
            throw new HttpException("Group Doesn't Exist");
        }
        $courseStudent->group = $group;
        $this->courseStudentMapper->edit($courseStudent);

        $this->request->getSession()->setFlash("success",sprintf(" STUDENT -> %s  ADDED TO GROUP -> %s  of COURES %s",$courseStudent->student->fullname,$group->name,$courseStudent->course->name));
        return new RedirectResponse('/show-students');
    }

    public function getGroup(int $course_id): Response
    {
        $response =  new Response();
        // maybe i should create a api function in abstract controller something like the render function that will build response
        $response->setHeader("Content-Type","application/json");
        $groups = $this->groupRepo->getGroupsValidByCourseId($course_id);
        if($groups === null){
            $response->setContent(json_encode(array()));
        }else{
            $groupData = array_map(function($group) {
                return [
                    'id' => $group->getId(), // Assuming getId() retrieves the teacher ID
                    'name'=>$group->name,
                    'teacher_name' => trim($group->teacher->fname . ' ' . $group->teacher->mname . ' ' . $group->teacher->lname), // Concatenate first, middle, and last names
                    'start_datetime'=> $group->start_datetime->format('Y-m-d H:i:s'),
                    'capacity' => $group->capacity
                ];
            }, $groups);
            $response->setContent(json_encode($groupData));
        }
        return $response;
    }

}