<?php

namespace Aimocs\Iis\Repo;

use Aimocs\Iis\Entity\User;
use Aimocs\Iis\Flat\Authentication\AuthRepoInterface;
use Aimocs\Iis\Flat\Authentication\AuthUserInterface;
use Aimocs\Iis\Flat\Database\Database;

class UserRepo implements AuthRepoInterface
{

    public function __construct(private Database $database)
    {
    }

    public function findById(int $id): ?AuthUserInterface
    {
        $result = $this->database->SelectByCriteria("users","*","id",[$id]);
        if(empty($result)){
            return null;
        }
        $result=$result[0];
        $user = new User(id: $result->id,username: $result->username,password: $result->password,createdAt: new \DateTimeImmutable($result->created_at));
        return $user;
    }

    public function findByUsername(string $username): ?AuthUserInterface
    {
        $result = $this->database->SelectByCriteria("users","*","username",[$username]);
        if(empty($result)){
            return null;
        }
        $result=$result[0];
        $user = new User(id: $result->id,username: $result->username,password: $result->password,createdAt: new \DateTimeImmutable($result->created_at));

        return $user;
    }
}