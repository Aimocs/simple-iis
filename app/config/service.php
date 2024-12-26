<?php

use Aimocs\Iis\Flat\DotEnvLoader\DotEnvLoader;
//start dotLoader
$dotEnv = new DotEnvLoader(dirname(__DIR__) . '/.env'); // Specify the path to your .env file
$dotEnv->load();

$container = new \Aimocs\Iis\Flat\Container\Container();
$container->delegate( new \Aimocs\Iis\Flat\Container\ReflectionContainer($container));
// arguments for application config
$basePath = dirname(__DIR__);

$container->add('basePath', new \Aimocs\Iis\Flat\Container\Argument\LiteralArgument($basePath));

$routes = include $basePath.'/routes/routes.php';

$appEnv = $_ENV['APP_ENV'];

$templateDirectory = $basePath."/templates";
$DB_HOST = $_ENV["MYSQL_HOST"];

$DB_PASSWORD = $_ENV['MYSQL_PASSWORD'];

$DB_USER = $_ENV["MYSQL_USER"];

$DB_NAME = $_ENV['MYSQL_DATABASE'];

$DB_ROOT_PASSWORD = $_ENV['MYSQL_ROOT_PASSWORD'];
// START ADDING SERVICES
$container->add("APP_ENV",new \Aimocs\Iis\Flat\Container\Argument\LiteralArgument($appEnv));

$container->add(\Aimocs\Iis\Flat\Routing\RouterInterface::class,\Aimocs\Iis\Flat\Routing\Router::class);

$container->add(\Aimocs\Iis\Flat\Http\Middleware\RequestHandlerInterface::class,\Aimocs\Iis\Flat\Http\Middleware\RequestHandler::class)->addArgument($container);

$container->addShared(\Aimocs\Iis\Flat\EventDispatcher\EventDispatcher::class);

$container->add(\Aimocs\Iis\Flat\Http\Kernel::class)
    ->addArguments([
        $container,
        \Aimocs\Iis\Flat\Http\Middleware\RequestHandlerInterface::class,
        \Aimocs\Iis\Flat\EventDispatcher\EventDispatcher::class
        ]);

$container->addShared(\Aimocs\Iis\Flat\Session\SessionInterface::class,\Aimocs\Iis\Flat\Session\Session::class);

$container->addShared("template-engine",Aimocs\Iis\Flat\TemplateEngine\Engine::class)->addArgument(new \Aimocs\Iis\Flat\Container\Argument\LiteralArgument($templateDirectory))->addArgument(\Aimocs\Iis\Flat\Session\SessionInterface::class);

$container->add(\Aimocs\Iis\Flat\Controller\AbstractController::class);
$container->inflector(\Aimocs\Iis\Flat\Controller\AbstractController::class)->invokeMethod("setContainer",[$container]);


$container->addShared(\Aimocs\Iis\Flat\Database\Database::class)
    ->addArgument(new \Aimocs\Iis\Flat\Container\Argument\LiteralArgument($DB_HOST))
    ->addArgument(new \Aimocs\Iis\Flat\Container\Argument\LiteralArgument($DB_NAME))
    ->addArgument(new \Aimocs\Iis\Flat\Container\Argument\LiteralArgument($DB_USER))
    ->addArgument(new \Aimocs\Iis\Flat\Container\Argument\LiteralArgument($DB_PASSWORD));

$container->add(\Aimocs\Iis\Flat\Http\Middleware\RouterDispatch::class)
    ->addArguments([
        \Aimocs\Iis\Flat\Routing\RouterInterface::class,
        $container
    ]);

$container->add(\Aimocs\Iis\Flat\Http\Middleware\ExtractRouteInfo::class)->addArgument(new \Aimocs\Iis\Flat\Container\Argument\LiteralArgument($routes));

return $container;