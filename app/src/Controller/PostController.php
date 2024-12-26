<?php

namespace Aimocs\Iis\Controller;

use Aimocs\Iis\Entity\Post;
use Aimocs\Iis\Flat\Controller\AbstractController;
use Aimocs\Iis\Flat\Http\RedirectResponse;
use Aimocs\Iis\Flat\Http\Response;
use Aimocs\Iis\Flat\Session\Session;
use Aimocs\Iis\Flat\Session\SessionInterface;
use Aimocs\Iis\Repo\PostMapper;
use Aimocs\Iis\Repo\PostRepo;
use Aimocs\Iis\Repo\UserRepo;

class PostController extends AbstractController
{
    public function __construct(
        private PostMapper $postMapper,
        private PostRepo $postRepo,
        private UserRepo $userRepo
    )
    {
    }

    public function show(int $id):Response
    {
        $post = $this->postRepo->findOrFail($id);
        return $this->render('pages/show.post',["title"=>"Post SHOWER","id"=>$id,"post"=>$post]);
    }

    public function showAll(): Response
    {
        $postList = $this->postRepo->getAll();
       return $this->render('pages/showAll.post',["title"=>"POST LIST","posts"=>$postList]);
    }

    public function create():Response
    {
        return $this->render('pages/create.post',['title'=>"YOUNO WAY"]);

    }

    public function store():Response
    {
        $title = $this->request->postParams['title'];
        $body = $this->request->postParams['body'];
        $user = $this->userRepo->findById($this->request->getSession()->get(Session::AUTH_KEY));
        $post = Post::create($title, $body,$user);
        $this->postMapper->save($post);
        $this->request->getSession()->setFlash(
            "success",
            sprintf("POST '%s' successfully created",$title)
        );
        return new RedirectResponse('/posts');
    }
}