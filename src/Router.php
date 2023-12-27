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

    public function __construct(string $projectUrl, $separator = ":")
    {
        $this->projectUrl = rtrim($projectUrl, "/");
        $this->separator = $separator;
    }

    public function get(string $path, string $handler)
    {
        $this->path = rtrim($path, "/");
        $this->addRoute("GET", $path);
    }

    public function addRoute(string $httpMethod, string $path)
    {
        $url = filter_input(INPUT_GET, "route", FILTER_DEFAULT);

        $route = function () use ($httpMethod, $path) {

        }
    }
}