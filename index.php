<?php

require "vendor/autoload.php";

$router = new App\Router\Router($_GET["url"]);
/*
 * Available routes method :
 * GET - POST
 * $router->METHOD(PATH :OPTIONS, CALLABLE, NAME)->with(PARAM, REGEX)
 */


$router->get('/', "Home#welcome" );
$router->get('/:name', "Home#welcome" );

$router->run();