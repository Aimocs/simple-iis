<?php

namespace Aimocs\Iis\Controller;

use Aimocs\Iis\Flat\Controller\AbstractController;
use Aimocs\Iis\Flat\Http\Response;

class DashboardController extends AbstractController
{

    public function index(): Response
    {
        return $this->render("pages/dash",["title"=>"YOLO DASHBOARD"]);
    }

}