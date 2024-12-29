<?php

use Aimocs\Iis\Flat\Http\Response;

return [
    ['GET','/',[\Aimocs\Iis\Controller\HomeController::class,'index']],
    ['GET','/posts/list',[\Aimocs\Iis\Controller\PostController::class,'showAll']],
    ['GET','/posts/{id}',[\Aimocs\Iis\Controller\PostController::class,'show']],
    ['GET','/posts',[\Aimocs\Iis\Controller\PostController::class,'create',[\Aimocs\Iis\Flat\Http\Middleware\Authenticate::class]]],
    ['POST','/posts',[\Aimocs\Iis\Controller\PostController::class,'store',[\Aimocs\Iis\Flat\Http\Middleware\Authenticate::class]]],
    ['GET','/register',[\Aimocs\Iis\Controller\RegistrationController::class,'index',[\Aimocs\Iis\Flat\Http\Middleware\Guest::class]]],
    ['POST','/register',[\Aimocs\Iis\Controller\RegistrationController::class,'register']],
    ['GET','/login',[\Aimocs\Iis\Controller\LoginController::class,'index',[\Aimocs\Iis\Flat\Http\Middleware\Guest::class]]],
    ['GET','/logout',[\Aimocs\Iis\Controller\LoginController::class,'logout',[\Aimocs\Iis\Flat\Http\Middleware\Authenticate::class]]],
    ['POST','/login',[\Aimocs\Iis\Controller\LoginController::class,'login']],
    ['GET','/add-category',[\Aimocs\Iis\Controller\CategoryController::class,'index']],
    ['POST','/add-category',[\Aimocs\Iis\Controller\CategoryController::class,'store']],
    ['GET','/add-course',[\Aimocs\Iis\Controller\CourseController::class,'index']],
    ['POST','/add-course',[\Aimocs\Iis\Controller\CourseController::class,'store']],
    ['GET','/add-employee',[\Aimocs\Iis\Controller\EmployeeController::class,'index']],
    ['POST','/add-employee',[\Aimocs\Iis\Controller\EmployeeController::class,'store']],
    ['GET','/add-student',[\Aimocs\Iis\Controller\StudentController::class,'index']],
    ['POST','/add-student',[\Aimocs\Iis\Controller\StudentController::class,'store']],
    ['GET','/dash',[\Aimocs\Iis\Controller\DashboardController::class,'index',
        [
            \Aimocs\Iis\Flat\Http\Middleware\Authenticate::class,
            \Aimocs\Iis\Flat\Http\Middleware\Dummy::class

        ]
    ]]
];

