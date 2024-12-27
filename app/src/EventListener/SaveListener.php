<?php

namespace Aimocs\Iis\EventListener;

use Aimocs\Iis\Flat\Database\Event\PostPersist;

class SaveListener
{
    public function __invoke(PostPersist $event)
    {
//        $event->getSession()->setFlash("success","yo check your emails!!");

    }

}