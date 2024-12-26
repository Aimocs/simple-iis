<?php

namespace Aimocs\Iis\Controller;

use Aimocs\Iis\Flat\Controller\AbstractController;
use Aimocs\Iis\Flat\Database\Database;
use Aimocs\Iis\Flat\Http\Response;
use Aimocs\Iis\Flat\TemplateEngine\Engine;
use Aimocs\Iis\testclass;

class HomeController extends AbstractController
{
    public function __construct()
    {
    }

    public function index(): Response
    {
        $response=$this->render("index",["title"=>"Dash","name"=>"from container from abstract controller"]);
        return $response;
    }
}