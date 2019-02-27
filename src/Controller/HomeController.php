<?php

namespace App\Controller;

class HomeController {
    private $container;
    public function __construct($container) {
        $this->container = $container;
    }

    public function welcome($name = null) {
        echo "Salut $name <pre>";
        var_dump($this->container);
        echo "</pre>";
    }
}