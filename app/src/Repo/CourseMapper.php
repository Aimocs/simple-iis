<?php

namespace Aimocs\Iis\Repo;

use Aimocs\Iis\Entity\Course;
use Aimocs\Iis\Flat\Database\DataMapper;

class CourseMapper
{
    private string $table = "courses";

    public function __construct(private DataMapper $dataMapper)
    {
    }

    public function save(Course $course)
    {
        $createdAt = ($course->getCreatedAt())->format('Y-m-d H:i:s');
        $id = $this->dataMapper->getDatabase()->Insert($this->table, ['name' => $course->name, 'short_description' => $course->short_description,'price'=>$course->price,'duration'=>$course->duration,'category_id'=>$course->getCategoryId(), 'created_at' => $createdAt]);
        $this->dataMapper->save($course); // to dispatch postpresist event
        $course->setId($id);
    }

}




