<?php

class Router
{
    protected static $route;
    protected $url;
    protected $separator;
    protected $httpMethod;
    protected $patch;


    public function __construct($url, $separator)
    {
        $this->url = $url;
        $this->separator = $separator;
        $this->httpMethod = $_SERVER["REQUEST_METHOD"];
        $this->patch = (filter_input(INPUT_GET, "route", FILTER_SANITIZE_STRIPPED));
    }

    public function get($route, $handler)
    {
        $this->createRoute("GET", $route, $handler);
    }

    public function post()
    {

    }

    public function createRoute(string $method, string $route, $handler)
    {
        preg_match_all("/{([^}]+)}(.*)/U", $route, $key, PREG_SET_ORDER);
        $dataDiff = array_values(array_diff(explode("/", $this->patch), explode("/", $route)));
        var_dump($key, $dataDiff);

        

    }

}