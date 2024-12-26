<?php

$providers =[
    \Aimocs\Iis\Provider\EventServiceProvider::class
];

foreach($providers as $providerClass){
    $provider = $container->get($providerClass);
    $provider->register();
}
