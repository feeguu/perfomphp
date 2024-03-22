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
        $route = explode('?', $_SERVER['REQUEST_URI'])[0]; 
        $controller = $this->routeMap[$route];
        if (!$controller) {
            http_response_code(404);
            exit();
        }
        $c = new $controller;
        $c->handleRequest();
    }
}