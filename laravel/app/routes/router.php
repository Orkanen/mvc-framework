<?php

/**
 * Load the routes into the router, this file is included from
 * `htdocs/index.php` during the bootstrapping to prepare for the request to
 * be handled.
 */

declare(strict_types=1);

use FastRoute\RouteCollector;

$router = $router ?? new RouteCollector(
    new \FastRoute\RouteParser\Std(),
    new \FastRoute\DataGenerator\MarkBased()
);

$router->addRoute("GET", "/test", function () {
    // A quick and dirty way to test the router or the request.
    return "Testing response";
});

$router->addRoute("GET", "/", "\Fian\Controller\Index");
$router->addRoute("GET", "/debug", "\Fian\Controller\Debug");
$router->addRoute("GET", "/twig", "\Fian\Controller\TwigView");

$router->addGroup("/session", function (RouteCollector $router) {
    $router->addRoute("GET", "", ["\Fian\Controller\Session", "index"]);
    $router->addRoute("GET", "/destroy", ["\Fian\Controller\Session", "destroy"]);
});

$router->addGroup("/some", function (RouteCollector $router) {
    $router->addRoute("GET", "/where", ["\Fian\Controller\Sample", "where"]);
});

$router->addGroup("/dice", function (RouteCollector $router) {
    $router->addRoute("GET", "", ["\Fian\Controller\DiceView", "index"]);
    $router->addRoute("POST", "/info", ["\Fian\Controller\DiceView", "info"]);
    $router->addRoute("GET", "/info", ["\Fian\Controller\DiceView", "info"]);
});

$router->addGroup("/yatzy", function (RouteCollector $router) {
    $router->addRoute("GET", "", ["\Fian\Controller\YatzyView", "index"]);
    $router->addRoute("GET", "/destroy", ["\Fian\Controller\YatzyView", "destroy"]);
    $router->addRoute("GET", "/firstRoll", ["\Fian\Controller\YatzyView", "firstRoll"]);
    $router->addRoute("POST", "/firstRoll", ["\Fian\Controller\YatzyView", "reRoll"]);
});

$router->addGroup("/yatzy/roll", function (RouteCollector $router) {
    //$router->addRoute("GET", "", ["\Fian\Controller\YatzyView", "reRoll"]);
    $router->addRoute("POST", "", ["\Fian\Controller\YatzyView", "reRoll"]);
});
