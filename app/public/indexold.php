<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/vendor/autoload.php';
// create a request
use Aimocs\Iis\Flat\Http\Request;
use Aimocs\Iis\Flat\Http\Response;

require_once dirname(__DIR__) . '/config/service.php';
$request = Request::createFromGlobals();
// handle the request and provide response
$container = new \Aimocs\Iis\Flat\Container\Container();
$container->delegate(new \Aimocs\Iis\Flat\Container\ReflectionContainer($container));
//$container->add(\Aimocs\Iis\Tests\ContainerTest\CTDependantClass::class);

$routeCollector =new  \Aimocs\Iis\Flat\Router\RouteCollector();
$routeCollector->addRoute("GET","/test/{id}",function(){
    $content = '<h1>FROM HOMEMADE ROUTER</h1>';
    return new Response($content);
});
$dispatcher = new \Aimocs\Iis\Flat\Router\Dispatcher($routeCollector);
dd($dispatcher);
$path = $request->getPath();
$method = $request->getMethod();
$routeInfo = $dispatcher->dispatch($path, $method);
$container->add(\Aimocs\Iis\BaseController::class);
$container->inflector(\Aimocs\Iis\BaseController::class)->invokeMethod("setContainer",[$container]);
dump("route INFO",$routeInfo);
dump($container->get($routeInfo[1][0]));
//$parser = new \Aimocs\Iis\Flat\Router\RouteParser();
//dump($result1 = $parser->parse("/user/someting", "/user/someting"));
dd($dispatcher);