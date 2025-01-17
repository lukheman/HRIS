<?php

namespace App\Core;

use App\Controllers\AuthController;

class Router
{
    private $routes = [];
    private $middleware = [];
    private $prefix;
    private $authController;
    protected $blade;


    public function __construct($blade)
    {
        $this->blade = $blade;
        $this->authController = new AuthController($this->blade);
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

        /*echo '<pre>';*/
        /*print_r($this->getRoutes());  // Menampilkan semua rute yang terdaftar*/
        /*echo '</pre>';*/
        /*exit();*/

        foreach($this->routes as $route) {
            $pattern = $this->convertPathToRegex($route['path']);

            if($route['method'] === $method && preg_match($pattern, $path, $matches)) {
                // check middleware
                // var_dump($route['middleware']);
                // exit();
                foreach(array_merge($this->middleware, $route['middleware']) as $middleware) {
                    $middlewareClass = "App\\Middleware\\{$middleware}";
                    $middlewareObj = new $middlewareClass();

                    // var_dump( $middlewareObj->handle());
                    // echo "akmal";
                    // exit();

                    if(!$middlewareObj->handle()) {
                        // $this->authController->showLogin();
                        header('Location: /login');
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
