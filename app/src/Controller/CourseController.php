<?php

namespace Aimocs\Iis\Controller;

use Aimocs\Iis\Flat\Controller\AbstractController;
use Aimocs\Iis\Flat\Http\RedirectResponse;
use Aimocs\Iis\Flat\Http\Response;
use Aimocs\Iis\Form\Course\CourseForm;
use Aimocs\Iis\Repo\CategoryRepo;
use Aimocs\Iis\Repo\CourseMapper;
use Aimocs\Iis\Repo\CourseRepo;

class CourseController extends AbstractController
{
    public function __construct(private CourseMapper $courseMapper,private CategoryRepo $categoryRepo,private CourseRepo $courseRepo)
    {
    }

    public function index(): Response
    {
        $categories = $this->categoryRepo->getAll();
        return $this->render("pages/course/add.course",["title"=>"Add Course","categories"=>$categories]);

    }

    public function showAll():Response
    {
        $courses= $this->courseRepo->getAll();
        return $this->render("pages/course/show.course",["title"=>"Show Course","courses"=>$courses]);

    }
    public function store(): Response
    {

        $form = new CourseForm($this->courseMapper,$this->categoryRepo);
        $form->setFields(
            $this->request->input('name'),
            $this->request->input('short_description'),
            $this->request->input('duration'),
            $this->request->input('price'),
            $this->request->input('category')
        );
        if($form->hasValidationErrors()){
            foreach($form->getValidationErrors() as $error){
                $this->request->getSession()->setFlash("error", $error);
            }
            return new RedirectResponse("/add-course");
        }
        $course = $form->save();
        $this->request->getSession()->setFlash("success",sprintf("NEW COURSE ADDED!!! %s ",$course->name));
        return new RedirectResponse('/add-course');

    }

}