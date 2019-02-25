<?php

namespace App\Controller;

class HomeController {

    public function welcome($name = null) {
        echo "Welcome $name";
    }
}