<?php

namespace Aimocs\Iis;

use Psr\Container\ContainerInterface;

class BaseController
{
    private string $yo = "you";
    private ?ContainerInterface $container = null;
    public function setContainer($container=null)
    {
        $this->container= $container;
    }

}