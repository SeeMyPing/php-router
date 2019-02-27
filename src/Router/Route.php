<?php
/**
 * Created by IntelliJ IDEA.
 * User: seemyping
 * Date: 24/02/19
 * Time: 22:42
 */

namespace App\Router;


class Route
{
    private $path;
    private $callable;
    private $matches = [];
    private $params = [];
    private $container = [];
    public function __construct($path, $callable, $container)
    {
        $this->callable = $callable;
        $this->path = trim($path, '/');
        $this->container = $container;
    }

    /*
     * Used to constrain params to regex
     *
     */
    public function with($param, $regex) {
        $this->params[$param] = str_replace('(', '(?:', $regex);
        return $this;
    }

    public function match($url){
        $url = trim($url, '/');
        $path = preg_replace_callback('#:([\w]+)#', [$this, 'paramMatch'], $this->path);
        $regex = "#^$path$#i";
        if (!preg_match($regex, $url, $matches)) {
            return false;
        }
        array_shift($matches);
        $this->matches = $matches;
        return true;
    }

    private function paramMatch($match) {
        if(isset($this->params[$match[1]])){
            return '(' . $this->params[$match[1]] . ')';
        }
        return '([^/]+)';
    }

    public function call() {
        if(is_string($this->callable)) {
            $params = explode("#", $this->callable);
            $controller = "App\\Controller\\". $params[0] . "Controller";
            $controller = new $controller($this->container);
            return call_user_func_array([$controller, $params[1]], $this->matches);
        } else {
            return call_user_func_array($this->callable, $this->matches);
        }
    }

    public function getUrl($params) {
        $path = $this->path;
        foreach($params as $k => $v) {
            $path = str_replace(":$k", $v, $path);
        }
        return $path;
    }
}