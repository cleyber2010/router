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
        $this->httpMethod = $_SERVER["REQUEST_METHOD"];
    }

    public function get(string $path, string $handler)
    {
        $this->path = rtrim($path, "/");
        $this->handler = $handler;
        $this->addRoute($this->httpMethod, $path);
    }

    public function post(string $path, string $handler)
    {
        $this->path = rtrim($path, "/");
        $this->handler = $handler;
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

        if ($this->url != "/" && !in_array("", $keys) && !in_array("", $values) && count($keys) == count($values)) {
            $count = 0;
            foreach ($keys as $key) {
                $this->data[$key] = $values[$count];
                $count++;
            }
         }

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
        $path = array_diff(explode("/", $route["path"]), explode("/", trim($this->url, "/")));
        $url = array_diff(explode("/", trim($this->url, "/")), explode("/", $route["path"]));

        $route["path"] = str_replace($path, $url, $route["path"]);
        var_dump($this->url);
        if (!empty($route) && $route["path"] == trim($this->url, "/")) {
            $controller = $route["controller"];
            $method = $route["method"];
            $data = $route["data"];

            $newController = new $controller();
            if (method_exists($newController, $method)) {
                $newController->$method($data);
            } else {
                echo "METHOD NOT IMPLEMENTED";
            }
        } else {
            echo "NOT FOUND";
        }
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