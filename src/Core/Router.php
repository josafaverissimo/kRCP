<?php

namespace Src\Core;

class Router
{
    private array $routes;
    private string $requestUri;

    public function route(string $resource, string $controllerAndMethod): void
    {
        [$className, $method] = explode(":", $controllerAndMethod);
        $className = "Src\\App\\Controllers\\{$className}";

        $this->routes[$resource] = function () use ($className, $method) {
            $reflection = new \ReflectionClass($className);

            $obj = $reflection->newInstance();
            call_user_func([$obj, $method]);
        };
    }

    private function error404(): void
    {
        http_response_code(404);

        echo "Página não encontrada";
    }

    private function isRequestInRoutes($request): bool
    {
        $isRequestInRoutes = false;

        if(!empty($this->routes[$request])) {
            return true;
        }

        $routes = array_filter(
            array_keys($this->routes),
            fn($route) => strpos($route, "/:") !== false
        );
        foreach($routes as $route) {
            $routeLen = strlen($route);
            if(strncmp($route, $request, $routeLen) === 0) {
                $argument = str_replace($route, "", $request);
            }
        }

        return $isRequestInRoutes;
    }

    public function dispatch(): void
    {
        $request = preg_replace("/\/$/i", "", $_SERVER['REQUEST_URI']);
        $request = $request !== "" ? $request : "/";

        if (!$this->isRequestInRoutes($request)) {
            $this->error404();
            return;
        }

        $this->routes[$request]();
    }
}
