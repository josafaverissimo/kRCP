<?php

namespace Src\Core\Router;

class Uri
{
    public static function getCurrentUri(): string
    {
        if ($_SERVER['REQUEST_URI'] === "/") {
            return "/";
        }

        return rtrim(parse_url($_SERVER['REQUEST_URI'])["path"], "/");
    }

    public static function getHttpMethodRequest(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }
}