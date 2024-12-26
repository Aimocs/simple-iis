<?php

namespace Aimocs\Iis\Controller;

use Aimocs\Iis\Entity\User;
use Aimocs\Iis\Flat\Authentication\SessionAuthentication;
use Aimocs\Iis\Flat\Controller\AbstractController;
use Aimocs\Iis\Flat\Http\RedirectResponse;
use Aimocs\Iis\Flat\Http\Response;
use Aimocs\Iis\Flat\Session\SessionInterface;
use Aimocs\Iis\Repo\UserRepo;

class LoginController extends AbstractController
{
    public function index(): Response
    {
        return $this->render("pages/login",["title"=>"Login Page"]);
    }

    public function login():Response
    {
        $userRepo = $this->container->get(UserRepo::class);
        $session = $this->container->get(SessionInterface::class);
        $authComponent  = new SessionAuthentication($userRepo,$session);

        $userIsAuthenticated= $authComponent->authenticate($this->request->input("username"),$this->request->input("password"));
        if(!$userIsAuthenticated){
            $this->request->getSession()->setFlash("error","BAD CREDS");
            return  new RedirectResponse('/login');
        }
        $user = $authComponent->getUser();

        $this->request->getSession()->setFlash("success", "YOU ARE LOGGED IN AS {$user->getUsername()}");

        return new RedirectResponse("/dash");


    }

    public function logout():Response
    {
        $userRepo = $this->container->get(UserRepo::class);
        $session = $this->container->get(SessionInterface::class);
        $authComponent  = new SessionAuthentication($userRepo,$session);

        $authComponent->logout();

        $this->request->getSession()->setFlash("success","LOGGED OUT");

        return new RedirectResponse("/login");

    }


}