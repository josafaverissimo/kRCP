<?php

namespace Source\Core;

final class Helpers
{
    final private function __construct()
    {
    }

    public static function baseUrl(string $subpath = ""): string
    {
        $subpath = array_reduce(
            explode("/", $subpath),
            fn($subpath, $uri) => $subpath . "/" . str_replace("/", "", $uri),
            ""
        );
        return CONF_BASE_URL . $subpath;
    }

    public static function minify(string $string): string
    {
        return preg_replace(
            "/> +</",
            "><",
            preg_replace(
                "/\s+/i",
                " ",
                $string,
            )
        );
    }
}
