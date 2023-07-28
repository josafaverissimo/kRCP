<?php

namespace Source\Core;

use Source\App\Controllers\Home;

class Routes
{
    private array $routes;

    public function route(string $resource, string $controllerAndMethod): void
    {
        [$className, $method] = explode(":", $controllerAndMethod);
        $className = "Source\\App\\Controllers\\{$className}";


        $this->routes[$resource] = function() use ($className, $method){
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

    public function dispatch():void
    {
        $request = preg_replace("/\/$/i", "", $_SERVER['REQUEST_URI']);
        $request = $request !== "" ? $request : "/";

        if(!in_array($request, array_keys($this->routes))) {
            $this->error404();
            return;
        }

        $this->routes[$request]();
    }
}
