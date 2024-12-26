<?php

namespace Aimocs\Iis\Controller;

use Aimocs\Iis\Flat\Authentication\SessionAuthentication;
use Aimocs\Iis\Flat\Controller\AbstractController;
use Aimocs\Iis\Flat\Http\RedirectResponse;
use Aimocs\Iis\Flat\Http\Response;
use Aimocs\Iis\Flat\Session\SessionInterface;
use Aimocs\Iis\Form\User\RegistrationFrom;
use Aimocs\Iis\Repo\UserMapper;
use Aimocs\Iis\Repo\UserRepo;

class RegistrationController extends AbstractController
{
    public function __construct(private UserMapper $userMapper)
    {
    }

    public function index(): Response
    {

        return $this->render("pages/register.user",["title"=>"Registration FORM"]);

    }


    public function register(): Response
    {

        $form = new RegistrationFrom($this->userMapper);
        $form->setFields(
            $this->request->input("username"),
            $this->request->input("password")
        );

        if($form->hasValidationErrors()){
            foreach($form->getValidationErrors() as $error){
                $this->request->getSession()->setFlash("error", $error);
            }
            return new RedirectResponse("/register");
        }

        $user = $form->save();
        $userRepo = $this->container->get(UserRepo::class);
        $session = $this->container->get(SessionInterface::class);
        $authComponent  = new SessionAuthentication($userRepo,$session);
        $authComponent->login($user);
        $this->request->getSession()->setFlash("success",sprintf("YOU ARE A NEW USER WELCOME!!! %s ",$user->username));
        return new RedirectResponse("/dash");
    }

}