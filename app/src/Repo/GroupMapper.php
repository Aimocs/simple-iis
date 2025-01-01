<?php

namespace Aimocs\Iis\Repo;

use Aimocs\Iis\Entity\Group;
use Aimocs\Iis\Flat\Database\DataMapper;

class GroupMapper
{
    private string $table = "groups";

    public function __construct(
        private DataMapper $dataMapper
    )
    {
    }

    public function save(Group $group)
    {
        $start_datetime = ($group->start_datetime)->format('Y-m-d H:i:s');
        $created_at = ($group->getCreatedAt())->format('Y-m-d H:i:s');
        $insertParams = ["course_id"=>$group->course->getId(),"teacher_id"=>$group->teacher->getId(),"name"=>$group->name,"start_datetime"=>$start_datetime,"created_at"=>$created_at];
        if($group->capacity !== null ){
            $insertParams["capacity"]= $group->capacity;
        }
        $id = $this->dataMapper->getDatabase()->Insert($this->table,$insertParams);
        $group->setId($id);
    }
}