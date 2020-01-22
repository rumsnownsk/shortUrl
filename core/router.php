<?php

// Настройки DI
use DI\ContainerBuilder;
use FastRoute\RouteCollector;
use League\Plates\Engine;

$containerBuilder = new ContainerBuilder;
$containerBuilder->addDefinitions([
    Engine::class => function () {
        return new Engine(VIEWS);
    },

]);
try {
    $container = $containerBuilder->build();
} catch (Exception $e) {
    echo 'ContainerBuilder error: ' . $e->getMessage();
}

// Настройки Роутера
$dispatcher = FastRoute\simpleDispatcher(function (RouteCollector $r) {

    $r->addRoute('GET', '/', ['app\controllers\MainController', 'indexAction']);
    $r->addRoute('GET', '/{link}', ['app\controllers\MainController', 'getOrigLinkAction']);

    $r->addRoute('POST', '/shortlink', ['app\controllers\MainController', 'shortLinkAjaxAction']);

});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        require APP.'/views/errors/404.php';
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
//        echo "METHOD_NOT_ALLOWED - странно, вы не должны были сюда попасть";
        require APP.'/views/errors/404.php';
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        // ... call $handler with $vars
        //dd($handler, $vars);

//        $container = new Container();

        $container->call($handler, $vars);

        break;
}