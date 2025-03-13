<?php

namespace App\Core;

class Router
{
    private $routes = [];
    private $middleware = [];
    private $prefix;
    protected $blade;


    public function __construct($blade)
    {
        $this->blade = $blade;
        $this->prefix = $_ENV['BASE_URL'];
    }

    public function add($method, $path, $controller, $action, $middleware = [])
    {
        $path = $this->prefix . $path;
        $this->routes[] = [
          'method' => $method,
          'path' => $path,
          'controller' => $controller,
          'action' => $action,
          'middleware' => $middleware,
        ];
    }

    public function get($path, $controller, $action, $middleware = [])
    {
        $middleware = array_merge($this->middleware, $middleware);

        $this->add('GET', $path, $controller, $action, $middleware);
    }

    public function post($path, $controller, $action, $middleware = [])
    {
        $middleware = array_merge($this->middleware, $middleware);
        $this->add('POST', $path, $controller, $action, $middleware);
    }

    public function group($prefix, $middleware, $callback)
    {
        $previousMiddleware = $this->middleware;

        $previousPrefix = $this->prefix;

        $this->middleware = array_merge($this->middleware, $middleware);
        $this->prefix = $previousPrefix . $prefix;

        $callback($this);

        $this->middleware = $previousMiddleware;
        $this->prefix = $previousPrefix;

    }

    public function dispatch($method, $path)
    {

        foreach($this->routes as $route) {
            $pattern = $this->convertPathToRegex($route['path']);

            if($route['method'] === $method && preg_match($pattern, $path, $matches)) {

                foreach(array_merge($this->middleware, $route['middleware']) as $middleware) {
                    $middlewareClass = "App\\Middleware\\{$middleware}";
                    $middlewareObj = new $middlewareClass();


                    if(!$middlewareObj->handle()) {
                        header("Location: {$_ENV['BASE_URL']}/login");
                        exit();
                    }
                }

                $controller = new $route['controller']($this->blade);
                return call_user_func_array([$controller, $route['action']], array_slice($matches, 1));

            }
        }
        throw new \Exception('Route not found');
    }

    private function convertPathToRegex($path)
    {
        return '#^' . preg_replace('/\{([a-zA-Z]+)\}/', '([^/]+)', $path) . '$#';
    }

    public function getRoutes()
    {
        return $this->routes;
    }

}
