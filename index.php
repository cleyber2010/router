<?php

require __DIR__ . "/src/Router.php";
require __DIR__ . "/example/UserController.php";

$route = new Router(__DIR__ . "router", ":");

//$route->namespace("test");
$route->get("/rotas/{teste}", "UserController:home");

$route->get("/", "UserController:home");

$route->dispatch();