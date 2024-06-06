<?php

namespace App;

use DI\ContainerBuilder;
use FastRoute\RouteCollector;
use Relay\Relay;
use function FastRoute\simpleDispatcher;

class App
{
    protected $container;
    protected $dispatcher;

    public function __construct()
    {
        $this->setupContainer();
        $this->setupRoutes();
    }

    protected function setupContainer()
    {
        $containerBuilder = new ContainerBuilder();
        $this->container = $containerBuilder->build();
    }

    protected function setupRoutes()
    {
        $this->dispatcher = simpleDispatcher(function (RouteCollector $r) {
            require __DIR__ . '/../config/routes.php';
        });
    }

    public function getContainer()
    {
        return $this->container;
    }

    public function getDispatcher()
    {
        return $this->dispatcher;
    }

    public function handleRequest()
    {
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);

        $routeInfo = $this->dispatcher->dispatch($httpMethod, $uri);

        switch ($routeInfo[0]) {
            case \FastRoute\Dispatcher::NOT_FOUND:
                echo '404 Not Found';
                break;
            case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                echo '405 Method Not Allowed';
                break;
            case \FastRoute\Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];

                list($class, $method) = explode('@', $handler);
                $controller = $this->container->get($class);
                call_user_func_array([$controller, $method], $vars);
                break;
        }
    }
}
