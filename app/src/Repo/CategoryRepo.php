<?php

namespace Aimocs\Iis\Repo;

use Aimocs\Iis\Entity\Category;
use Aimocs\Iis\Flat\Database\Database;

class CategoryRepo
{
    private string $table = "categories";

    public function __construct(private Database $database)
    {
    }

    public function findById(int $id):?Category
    {
        $data =$this->database->SelectByCriteria($this->table,"*","id",[$id]);
        if(empty($data)){
            return null;
        }
        $data = $data[0];
        $name = $data->name;
        $description = $data->short_description;
        $category = Category::create($name,$description,$id,new \DateTimeImmutable($data->created_at) );
        return $category;
    }

    public function getAll()
    {
        $data =$this->database->SelectAll($this->table);
        if (empty($data)){
            return null;
        }

        $categories=[];
        foreach($data as $category){
            $categories[]= Category::create($category->name,$category->short_description,$category->id,new \DateTimeImmutable($category->created_at));
        }
        return $categories;
    }

}
