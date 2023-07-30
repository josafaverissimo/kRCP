<?php

namespace Src\Core\Router;

class Uri
{
    private string $uri;

    public function __construct()
    {
        $this->setUri($this->getCurrentUri());
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function setUri(string $uri): void
    {
        $this->uri = $uri;
    }

    public function getCurrentUri(): string
    {
        if ($_SERVER['REQUEST_URI'] === "/") {
            return "/";
        }

        return rtrim(parse_url($_SERVER['REQUEST_URI'])["path"], "/");
    }

    public function getHttpMethodRequest(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }
}