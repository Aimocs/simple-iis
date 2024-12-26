<?php

namespace Aimocs\Iis\Repo;

use Aimocs\Iis\Entity\Post;
use Aimocs\Iis\Entity\User;
use Aimocs\Iis\Flat\Database\Database;
use Aimocs\Iis\Flat\Http\NotFoundException;

class PostRepo
{
    private string $table = "posts";

    public function __construct(private Database $database, private UserRepo $userRepo)
    {
    }

    public function findById(int $id): ?Post
    {

        $data =$this->database->SelectByCriteria($this->table,"*","id",[$id]);
        if (empty($data)){
            return null;
        }
        $data = $data[0];
        $userId = $data->user_id;
        $user = $this->userRepo->findById($userId);
        $post = Post::create($data->title,$data->body,$user,$data->id,new \DateTimeImmutable($data->created_at) );
        return $post;
    }
    public function findOrFail(int $id): Post
    {
        $post = $this->findById($id);

        if (!$post) {
            throw new NotFoundException(sprintf('Post with ID %d not found', $id));
        }

        return $post;
    }

    public function getAll()
    {
        $data =$this->database->SelectAll($this->table);
        if (empty($data)){
            return null;
        }

        $posts=[];
        foreach($data as $post){
            $userId = $post->user_id;
            $user = $this->userRepo->findById($userId);
            $posts[]= Post::create($post->title,$post->body,$user,$post->id,new \DateTimeImmutable($post->created_at) );
        }
        return $posts;
    }

}