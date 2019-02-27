<?php

// TWIG
$loader = new Twig_Loader_Filesystem(__DIR__ . '/templates');
$container['render'] = new Twig_Environment($loader, [
    "cache" => false
]);


// Router preferences
$container['debug'] = false;
