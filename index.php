<?php

require __DIR__ . "/src/Router.php";

$route = new Router(__DIR__ . "router", ":");

$route->get("/rotas/{data}/{teste}/{page}", "TestController:list");