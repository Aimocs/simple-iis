<?php

namespace Aimocs\Iis\Controller;

use Aimocs\Iis\Flat\Controller\AbstractController;
use Aimocs\Iis\Flat\Http\RedirectResponse;
use Aimocs\Iis\Flat\Http\Response;
use Aimocs\Iis\Form\Category\CategoryForm;
use Aimocs\Iis\Repo\CategoryMapper;
use Aimocs\Iis\Repo\CategoryRepo;

class CategoryController extends AbstractController
{
    public function __construct(
        private CategoryMapper $categoryMapper,
        private CategoryRepo $categoryRepo
    )
    {
    }

    public function index():Response
    {
        return $this->render('pages/category/add.category',["title"=>"Add Category"]);
    }

    public function store():Response
    {
        $form  = new CategoryForm($this->categoryMapper);
        $form->setFields(
            $this->request->input('categoryName'),
            $this->request->input('description')
        );

        if($form->hasValidationErrors()){
            foreach($form->getValidationErrors() as $error){
                $this->request->getSession()->setFlash("error", $error);
            }
            return new RedirectResponse("/add-category");
        }
        $category  = $form->save();
        $this->request->getSession()->setFlash("success",sprintf("ADDED NEW CATEGORY -> %s ",$category->name));
        return new RedirectResponse('/add-category');
    }

}