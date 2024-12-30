<?php

namespace Aimocs\Iis\Repo;

use Aimocs\Iis\Entity\Course;
use Aimocs\Iis\Flat\Database\Database;

class CourseRepo
{
    private string $table = "courses";

    public function __construct(private Database $database, private CategoryRepo $categoryRepo)
    {
    }

    public function findById(int $id):?Course
    {
        $data =$this->database->SelectByCriteria($this->table,"*","id",[$id]);
        if(empty($data)){
            return null;
        }
        $course = $data[0];
        $category=$this->categoryRepo->findById($course->category_id);
        return Course::create($course->name,$course->short_description,$course->price,$category,$course->duration,$course->id,new \DateTimeImmutable($course->created_at));

    }

    public function getAll():?array
    {
        $data = $this->database->SelectAll($this->table);
        if(empty($data)){
            return null;
        }
        $courses = [];
        foreach($data as $course){
            $category=$this->categoryRepo->findById($course->category_id);
            $courses[]=Course::create($course->name,$course->short_description,$course->price,$category,$course->duration,$course->id,new \DateTimeImmutable($course->created_at));
        }
        return $courses;
    }

}