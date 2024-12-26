<?php

namespace Aimocs\Iis\Repo;

use Aimocs\Iis\Entity\User;
use Aimocs\Iis\Flat\Database\Database;
use Aimocs\Iis\Flat\Database\DataMapper;

class UserMapper
{
    private string $table = "users";
    public function __construct(private DataMapper $dataMapper)
    {
    }

    public function save(User $user)
    {
        $createdAt= ( $user->getCreatedAt() )->format('Y-m-d H:i:s');
        $id = $this->dataMapper->getDatabase()->Insert($this->table,['username'=>$user->getUsername(),'password'=>$user->getPassword(),'created_at'=>$createdAt]);
        $this->dataMapper->save($user);
        $user->setId($id);
    }

}