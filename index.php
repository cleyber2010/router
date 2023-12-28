<?php

ob_start();

require "src/Router.php";
require "exemple/UserController.php";

use WebRouter\Router;

$router = new Router("https://www.localhost/plugins/router/");

$router->get("usuario/cadastro/{id}/{user}", "UserController:index");
$router->get("usuario/cadastro/{id}/{user}/{test}", "UserController:index");


ob_end_flush();