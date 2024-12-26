<?php
declare(strict_types = 1);

use Aimocs\Iis\Flat\DotEnvLoader\DotEnvLoader;
use Aimocs\Iis\Flat\Http\Kernel;
use Aimocs\Iis\Flat\Http\Request;
use Aimocs\Iis\Flat\Routing\Router;

define("BASE_PATH",dirname(__DIR__));
require_once BASE_PATH. "/vendor/autoload.php";

//get container
$container = require BASE_PATH."/config/service.php";

// bootstrapping
require BASE_PATH.'/bootstrap/bootstrap.php';

//request received
$request = Request::createFromGlobals();

// perform some logic
$kernel= $container->get(Kernel::class);

// send response (string of content)
$response = $kernel->handle($request);

$response->send();

$kernel->terminate($request,$response);