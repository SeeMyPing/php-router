<?php
$debug = true;
require "vendor/autoload.php";

$loader = new Twig_Loader_Filesystem(__DIR__ . '/templates');
$container['render'] = new Twig_Environment($loader, [
    "cache" => false
]);
$container['debug'] = false;



$router = new App\Router\Router($_GET["url"], $container);

/*
 * Available routes method :
 * GET - POST
 * $router->METHOD(PATH :OPTIONS, CALLABLE, NAME)->with(PARAM, REGEX)
 */



$router->get('/', "Home#welcome" );
$router->get('/:name', "Home#welcome" );

$router->run();