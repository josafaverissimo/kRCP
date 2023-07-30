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


    public function __construct()
    {
        $this->groupOptions = [];
    }

    public function middlewares(array $middlewares)
    {
        $this->routeMiddlewares = $middlewares;
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

        $resource = RouteWildcard::replaceWildcard($resource);

        if ($this->groupOptionExists("prefix")) {
            $prefix = $this->getGroupOption("prefix");
            $resource = "/{$prefix}" . rtrim($resource, "/");
        }

        xdebug_var_dump($this->groupOptions);

        $this->routes[$httpMethod][$resource] = function (...$args) use ($classPath, $method) {
            $controller = new $classPath;
            $controller->$method(...$args);
        };
    }

    public function group(array $options, Closure $callback): void
    {
        $this->groupOptions = $options;
        $callback->call($this);
        $this->groupOptions = [];
    }

    public function get(string $resource, string $controllerAndMethod): Router
    {
        $this->route("get", $resource, $controllerAndMethod);

        return $this;
    }

    public function post(string $resource, string $controllerAndMethod): Router
    {
        $this->route("post", $resource, $controllerAndMethod);

        return $this;
    }

    public function put(string $resource, string $controllerAndMethod): Router
    {
        $this->route("put", $resource, $controllerAndMethod);

        return $this;
    }

    public function delete(string $resource, string $controllerAndMethod): Router
    {
        $this->route("delete", $resource, $controllerAndMethod);

        return $this;
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
        $httpMethod = Uri::getHttpMethodRequest();
        $routes = array_keys($this->routes[$httpMethod]);
        RouteWildcard::uriEqualToPattern($request, $routes[5]);

        foreach ($routes as $route) {
            if (RouteWildcard::uriEqualToPattern($request, $route)) {
                return $route;
            }
        }

        return null;
    }

    public function dispatch(): void
    {
        $request = Uri::getCurrentUri();
        $route = $this->getRoute($request);

        if (empty($route)) {
            $this->error404();
            return;
        }

        $httpMethod = Uri::getHttpMethodRequest();
        $params = RouteWildcard::paramsToArray($request, $route);

        $this->routes[$httpMethod][$route](...$params);
    }
}
