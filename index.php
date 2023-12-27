<?php

ob_start();

require "src/Router.php";

use WebRouter\Router;

$router = new Router("https://www.localhost/plugins/router/");

$router->get("usuario/cadastro", "UserController:index");

var_dump($router);

ob_end_flush();