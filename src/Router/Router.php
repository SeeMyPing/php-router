<?php
/**
 * Created by IntelliJ IDEA.
 * User: seemyping
 * Date: 24/02/19
 * Time: 22:40
 */

namespace App\Router;


class Router
{
    private $url;
    private $routes = [];
    private $namedRoutes = [];
    private $container = [];
    public function __construct($url, $container)
    {
        $this->url = $url;
        $this->container = $container;
    }

    public function get($path, $callable, $name = null) {
        return $this->add($path, $callable, $name, 'GET');
    }
    public function post($path, $callable, $name = null) {
        return $this->add($path, $callable, $name, 'POST');
    }

    public function add($path, $callable, $name = null, $method) {
        $route = new Route($path, $callable, $this->container);
        $this->routes[$method][] = $route;
        if(is_string($callable) && $name === null) {
            $name = $callable;
        }
        if($name){
            $this->namedRoutes[$name] = $route;
        }
        return $route;
    }

    public function run(){
        if (!isset($this->routes[$_SERVER['REQUEST_METHOD']])) {
            //throw new RouterException('No methods matches');
            throw new \Exception('No methods matches');
        }
        foreach($this->routes[$_SERVER['REQUEST_METHOD']] as $route){
            if($route->match($this->url)) {
                $route->call();
            }
        }
        //throw new RouterException('Route does not exists');
        throw new \Exception('Route does not exists');

    }

    /*
     * Used to get route
     */
    public function url($name, $params = []) {
        if(!isset($this->namedRoutes[$name])) {
            //throw new RouterException('No routes matches this name');
            throw new \Exception('No routes matches this name');
        }
        return $this->namedRoutes[$name]->getUrl($params);
    }

    public function getContainer() {
        return $this->container;
    }
}