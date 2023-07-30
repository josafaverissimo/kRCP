<?php

namespace Src\Core\Router;

use Closure;

class Router
{
    private const CONTROLLER_NAMESPACE = "Src\\App\\Controllers\\";
    private const ROUTES_PATTERNS = [
        "(:numeric)" => "[0-9]+",
        "(:alpha)" => "[a-zA-Z]+",
        "(:any)" => "[a-zA-Z0-9\-]+"
    ];
    private array $routes;
    private array $groupOptions;
    private Uri $uri;


    public function __construct()
    {
        $this->groupOptions = [];
        $this->uri = new Uri();
    }

    private function route(string $httpMethod, string $resource, string $controllerAndMethod): void
    {
        [$className, $method] = explode(":", $controllerAndMethod);
        $classPath = "";

        if ($this->groupOptionExists("controllersDir")) {
            $controllersDir = $this->getGroupOption("controllersDir");
            $classPath = self::CONTROLLER_NAMESPACE . "{$controllersDir}\\{$className}";
        } else {
            $classPath = self::CONTROLLER_NAMESPACE . "{$className}";
        }

        foreach (self::ROUTES_PATTERNS as $patternIdentifier => $pattern) {
            $resource = str_replace($patternIdentifier, $pattern, $resource);
        }

        if ($this->groupOptionExists("prefix")) {
            $prefix = $this->getGroupOption("prefix");
            $resource = "/{$prefix}" . rtrim($resource, "/");
        }

        $this->routes[$httpMethod][$resource] = function (...$args) use ($classPath, $method) {
            $controller = new $classPath;
            $controller->$method(...$args);
        };
    }

    public function group(array $options, Closure $callback)
    {
        $this->groupOptions = $options;
        $callback->call($this);
        $this->groupOptions = [];
    }

    public function get(string $resource, string $controllerAndMethod): void
    {
        $this->route("get", $resource, $controllerAndMethod);
    }

    public function post(string $resource, string $controllerAndMethod): void
    {
        $this->route("post", $resource, $controllerAndMethod);
    }

    public function put(string $resource, string $controllerAndMethod): void
    {
        $this->route("put", $resource, $controllerAndMethod);
    }

    public function delete(string $resource, string $controllerAndMethod): void
    {
        $this->route("delete", $resource, $controllerAndMethod);
    }

    private function error404(): void
    {
        http_response_code(404);

        echo "Página não encontrada";
    }

    private function groupOptionExists($option): bool
    {
        if (empty($this->groupOptions)) {
            return false;
        }

        return !empty($this->groupOptions[$option]);
    }

    private function getGroupOption($prefix)
    {
        return $this->groupOptions[$prefix];
    }

    private function getRoute($request): ?string
    {
        $httpMethod = $this->uri->getHttpMethodRequest();
        $routes = array_keys($this->routes[$httpMethod]);

        foreach ($routes as $route) {
            $pattern = str_replace("/", '\/', ltrim($route, "/"));

            if (preg_match("/^$pattern$/", ltrim($request, "/"))) {
                return $route;
            }
        }

        return null;
    }

    public function dispatch(): void
    {
        $request = $this->uri->getUri();
        $route = $this->getRoute($request);

        if (empty($route)) {
            $this->error404();
            return;
        }

        $httpMethod = $this->uri->getHttpMethodRequest();

        $routeExploded = explode("/", ltrim($route, "/"));
        $requestExploded = explode("/", ltrim($request, "/"));
        $routeAndRequestDiff = array_diff($requestExploded, $routeExploded);
        $params = [];

        foreach ($routeAndRequestDiff as $index => $uri) {
            $params[$requestExploded[$index - 1]] = $uri;
        }

        $this->routes[$httpMethod][$route](...$params);
    }
}
