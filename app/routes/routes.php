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
    ['GET','/show-categories',[\Aimocs\Iis\Controller\CategoryController::class,'showAll']],
    ['GET','/add-category',[\Aimocs\Iis\Controller\CategoryController::class,'index']],
    ['POST','/add-category',[\Aimocs\Iis\Controller\CategoryController::class,'store']],
    ['GET','/show-courses',[\Aimocs\Iis\Controller\CourseController::class,'showAll']],
    ['GET','/add-course',[\Aimocs\Iis\Controller\CourseController::class,'index']],
    ['POST','/add-course',[\Aimocs\Iis\Controller\CourseController::class,'store']],
    ['GET','/show-employees',[\Aimocs\Iis\Controller\EmployeeController::class,'showAll']],
    ['GET','/show-roles-employee',[\Aimocs\Iis\Controller\EmployeeController::class,'role_showAll']],
    ['GET','/add-employee',[\Aimocs\Iis\Controller\EmployeeController::class,'index']],
    ['GET','/edit-employee/{employee_id}',[\Aimocs\Iis\Controller\EmployeeController::class,'edit_page']],
    ['POST','/edit-employee',[\Aimocs\Iis\Controller\EmployeeController::class,'edit']],
    ['POST','/add-employee',[\Aimocs\Iis\Controller\EmployeeController::class,'store']],
    ['GET','/add-role-employee',[\Aimocs\Iis\Controller\EmployeeController::class,'role_index']],
    ['POST','/add-role-employee',[\Aimocs\Iis\Controller\EmployeeController::class,'role_store']],
    ['GET','/api/get-course-teachers/{course_id}',[\Aimocs\Iis\Controller\GroupController::class,'getTeacher']],
    ['GET','/add-group',[\Aimocs\Iis\Controller\GroupController::class,'index']],
    ['POST','/add-group',[\Aimocs\Iis\Controller\GroupController::class,'store']],
    ['GET','/edit-group/{group_id}',[\Aimocs\Iis\Controller\GroupController::class,'edit_page']],
    ['POST','/edit-group',[\Aimocs\Iis\Controller\GroupController::class,'edit']],
    ['POST','/add-group',[\Aimocs\Iis\Controller\GroupController::class,'store']],
    ['GET','/show-groups',[\Aimocs\Iis\Controller\GroupController::class,'showAll']],
    ['GET','/add-course-teacher',[\Aimocs\Iis\Controller\CourseTeacherController::class,'index']],
    ['POST','/add-course-teacher',[\Aimocs\Iis\Controller\CourseTeacherController::class,'store']],
    ['GET','/add-course-student',[\Aimocs\Iis\Controller\CourseStudentController::class,'index']],
    ['POST','/add-course-student',[\Aimocs\Iis\Controller\CourseStudentController::class,'store']],
    ['GET','/add-student-group',[\Aimocs\Iis\Controller\StudentGroupController::class,'index']],
    ['POST','/add-student-group',[\Aimocs\Iis\Controller\StudentGroupController::class,'edit']],
    ['GET','/api/get-course-groups/{course_id}',[\Aimocs\Iis\Controller\StudentGroupController::class,'getGroup']],
    ['GET','/add-student-payment',[\Aimocs\Iis\Controller\StudentPaymentController::class,'index']],
    ['GET','/show-student-payment/{student_id}',[\Aimocs\Iis\Controller\StudentPaymentController::class,'show']],
    ['POST','/add-student-payment',[\Aimocs\Iis\Controller\StudentPaymentController::class,'store']],
    ['GET','/add-student',[\Aimocs\Iis\Controller\StudentController::class,'index']],
    ['GET','/show-students',[\Aimocs\Iis\Controller\StudentController::class,'showAll']],
    ['POST','/add-student',[\Aimocs\Iis\Controller\StudentController::class,'store']],
    ['GET','/api/delete/{id}/{table}',[\Aimocs\Iis\Controller\DeleteController::class,'delete']],
    ['GET','/dash',[\Aimocs\Iis\Controller\DashboardController::class,'index',
        [
            \Aimocs\Iis\Flat\Http\Middleware\Authenticate::class,
            \Aimocs\Iis\Flat\Http\Middleware\Dummy::class
        ]
    ]]
];

