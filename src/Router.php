<?php

class Router
{
    protected $routes;
    protected $url;
    protected $separator;
    protected $httpMethod;
    protected $patch;
    protected $namespace;


    public function __construct($url, $separator)
    {
        $this->url = $url;
        $this->separator = $separator;
        $this->httpMethod = $_SERVER["REQUEST_METHOD"];
        $this->patch = (filter_input(INPUT_GET, "route", FILTER_SANITIZE_STRIPPED) ?? "/");
    }

    public function get($route, $handler)
    {
        $this->createRoute("get", $route, $handler);
    }

    public function post()
    {

    }

    protected function createRoute(string $method, string $route, $handler)
    {
        preg_match_all("/{([^}]+)}(.*)/U", $route, $key, PREG_SET_ORDER);
        $dataDiff = array_values(array_diff(explode("/", $this->patch), explode("/", $route)));
        $url = explode("/", $this->patch);
        $data = [];
        $i = 0;

        if (!empty($dataDiff)) {

            foreach ($key as $keys) {
                $data[$keys[1]] = $dataDiff[$i++];
            }

            if ($route != "/") {
                $url  = "/" . $url[1] . "/" . implode("/", array_keys($data));
                if (count(explode("/", $this->patch)) == count(explode("/", $url))) {
                    $this->patch = $url;
                }
            }

        }

        $route = preg_replace("/[^a-zA-Z0-9\/]/", "", $route);

        $this->routes[$route] = [
            strtoupper($method) => [
                "controller" => $this->handler($handler),
                "method" => $this->method($handler),
                "route" => $route,
                "data" => (!empty($data) ? $data : null)

            ]
        ];

    }

    public function dispatch(): void
    {
        var_dump($this->patch);
        if (empty($this->routes[$this->patch]) || empty($this->routes[$this->patch][$this->httpMethod])) {
            var_dump(405);
            return;
        }

        if (empty($this->routes[$this->patch])) {
            var_dump(401);
            return;
        }

        $route = $this->routes[$this->patch][$this->httpMethod];



        if (class_exists($route["controller"])) {
            $controller = $route["controller"];
            $controller = new $controller();
            $method = $route["method"];
            if (method_exists($controller, $method)) {
                if (!empty($route["data"])) {
                    $controller->$method($route["data"]);
                } else {
                    $controller->$method($route["data"]);
                }
            }
        } else {
            var_dump(401);
        }

    }

    public function namespace(string $namespace): ?string
    {
        $this->namespace = (!empty($namespace) ? $namespace . "\\" : null);
        return $this->namespace;
    }

    protected function handler(string $handler): string
    {
        return explode(":", $handler)[0];
    }

    protected function method(string $method)
    {
        return explode(":", $method)[1];
    }


}