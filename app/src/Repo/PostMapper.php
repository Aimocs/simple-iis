<?php

namespace Aimocs\Iis\Repo;

use Aimocs\Iis\Entity\Post;
use Aimocs\Iis\Flat\Database\Database;
use Aimocs\Iis\Flat\Database\DataMapper;

class PostMapper
{
    private string $table = "posts";
    public function __construct(private DataMapper $dataMapper)
    {
    }

    public function save(Post $post):void
    {
        $createdAt= ( $post->getCreatedAt() )->format('Y-m-d H:i:s');
        $id = $this->dataMapper->getDatabase()->Insert($this->table,['title'=>$post->getTitle(),'body'=>$post->getBody(),'user_id'=>$post->getUserId(),'created_at'=>$createdAt]);
        $this->dataMapper->save($post);
        $post->setId($id);
    }

}