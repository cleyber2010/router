<?php

namespace WebRouter;

class Router {

    /** @var string */
    protected string $projectUrl;

    /** @var string */
    protected string $separator;

    /** @var string */
    protected string $path;

    /** @var string */
    protected string $handler;

    /** @var string */
    protected string $httpMethod;

    /** @var string */
    protected string $method;

    /** @var array|null */
    protected ?array $route;

    /** @var string */
    protected string $url;

    /** @var array|null */
    protected ?array $data = [];

    public function __construct(string $projectUrl, $separator = ":")
    {
        $this->projectUrl = rtrim($projectUrl, "/");
        $this->separator = $separator;
    }

    public function get(string $path, string $handler)
    {
        $this->path = rtrim($path, "/");
        $this->handler = $handler;
        $this->httpMethod = "GET";
        $this->addRoute($this->httpMethod, $path);
    }

    public function post(string $path, string $handler)
    {
        $this->path = rtrim($path, "/");
        $this->handler = $handler;
        $this->httpMethod = "POST";
        $this->addRoute($this->httpMethod, $path);
    }

    public function addRoute(string $httpMethod, string $path)
    {
        $this->url = (filter_input(INPUT_GET, "route", FILTER_DEFAULT) ?? "/");

        $pathArr = explode("/", trim(str_replace("}", "", str_replace("{", "", $path)), "/"));
        $urlArr = explode("/", trim($this->url, "/"));

        $keys = array_diff(array_values($pathArr), array_values($urlArr));
        $values = array_diff(array_values($urlArr), array_values($pathArr));
        
        $keys = array_values($keys);
        $values = array_values($values);
        
        if ($this->url != "/") {
            $count = 0;
            foreach ($keys as $key) {
                $this->data[$key] = $values[$count];
                $count++;
            }
         }
        
        var_dump($this->data, $values);

        $route = function () use ($path) {
            return [
                "path" => $path,
                "controller" => $this->handler($this->handler),
                "method" => $this->method($this->handler),
                "data" => $this->data
            ];
        };

        $this->route[$httpMethod] = $route($path);

        $this->dispatch($this->route);
    }

    protected function dispatch(array $route)
    {
        $route = $route[$this->httpMethod];
        var_dump($route);
    }

    private function handler(string $handler)
    {
        return $controller = strstr($handler, ":", true);       
    }

    private function method(string $method)
    {
        return $method = substr(strstr($method, ":", false), 1);
    }
}