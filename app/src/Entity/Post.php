<?php

namespace Aimocs\Iis\Entity;

use Aimocs\Iis\Flat\Database\Entity;

class Post extends Entity
{
    public function __construct(
        private ?int $id,
        public string $title,
        public string $body,
        public ?User $user,
        private \DateTimeImmutable $createdAt
    )
    {
    }

    public static function create(
        string $title,
        string $body,
        ?User $user,
        ?int $id = null,
        ?\DateTimeImmutable $createdAt = null
    ): Post
    {
        return new self($id, $title, $body,$user, $createdAt ?? new \DateTimeImmutable());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getUserId():int
    {
        return $this->user->getAuthId();
    }

    public function getUsername():string
    {
        return $this->user->getUsername();
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }




}