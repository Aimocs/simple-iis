<?php

namespace Aimocs\Iis\Repo;

use Aimocs\Iis\Entity\Category;
use Aimocs\Iis\Flat\Database\DataMapper;

class CategoryMapper
{
    private string $table = "categories";

    public function __construct(private DataMapper $dataMapper)
    {
    }

    public function save(Category $category)
    {
        $createdAt= ( $category->getCreatedAt() )->format('Y-m-d H:i:s');
        $id = $this->dataMapper->getDatabase()->Insert($this->table,['name'=>$category->name,'short_description'=>$category->description,'created_at'=>$createdAt]);
        $this->dataMapper->save($category); // to dispatch postpresist event
        $category->setId($id);
    }

}