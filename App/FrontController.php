<?php

namespace App;

class FrontController {
    private $routeMap = [];

    public function __construct() {
        $this->routeMap = [
        ];
    }

    public function bind(string $route, string $controller) {
        $this->routeMap[$route] = $controller;
    }

    public function run() {
        $route = $_SERVER['REQUEST_URI']; 
        $controller = $this->routeMap[$route];
        $c = new $controller;
        $c->handleRequest();
    }
}