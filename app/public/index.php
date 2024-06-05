<?php


echo 5;
// phpinfo();
echo xdebug_info();
exit;

require_once __DIR__ . '/../vendor/autoload.php';


echo 555;
exit;

use DI\ContainerBuilder;
use Dotenv\Dotenv;
use FastRoute\RouteCollector;
use Relay\Relay;
use function FastRoute\simpleDispatcher;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$containerBuilder = new ContainerBuilder();
$container = $containerBuilder->build();

$dispatcher = simpleDispatcher(function (RouteCollector $r) {
    $r->addRoute('GET', '/user/{id:\d+}', 'App\Controllers\UserController@show');
    $r->addRoute('GET', '/articles/{title}', 'App\Controllers\ArticleController@show');
});

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo '404 Not Found';
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        echo '405 Method Not Allowed';
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        list($class, $method) = explode('@', $handler);
        $controller = $container->get($class);
        call_user_func_array([$controller, $method], $vars);
        break;
}