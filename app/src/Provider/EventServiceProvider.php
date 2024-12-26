<?php

namespace Aimocs\Iis\Provider;

use Aimocs\Iis\EventListener\ContentLengthListener;
use Aimocs\Iis\EventListener\InternalErrorListener;
use Aimocs\Iis\EventListener\SaveListener;
use Aimocs\Iis\Flat\Database\Event\PostPersist;
use Aimocs\Iis\Flat\EventDispatcher\EventDispatcher;
use Aimocs\Iis\Flat\Http\Event\ResponseEvent;
use Aimocs\Iis\Flat\ServiceProvider\ServiceProviderInterface;

class EventServiceProvider implements ServiceProviderInterface
{
    private array $listen = [
        ResponseEvent::class =>[
            InternalErrorListener::class,
            ContentLengthListener::class
        ],
        PostPersist::class =>[
            SaveListener::class
        ]
    ];
    public function __construct(private EventDispatcher  $eventDispatcher)
    {
    }

    public function register(): void
    {
        foreach($this->listen as $eventName => $listeners){

            foreach(array_unique($listeners) as $listener){

                $this->eventDispatcher->addListener($eventName, new $listener());
            }
        }
    }
}