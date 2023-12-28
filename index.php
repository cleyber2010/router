<?php

ob_start();

require "src/Router.php";

use WebRouter\Router;

$router = new Router("https://www.localhost/plugins/router/");

$router->get("usuario/cadastro/{id}/{user}", "UserController:index");
//$router->get("usuario/listar", "UserController:list");
//$router->post("usuario/listar", "UserController:list");

ob_end_flush();