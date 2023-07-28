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

        return CONF_BASE_URL . preg_replace("/\/+/", "/", $subpath);
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

    public static function jsonOutput(mixed $output): string
    {
        header("Content-type: Application/json");
        return json_encode($output);
    }

    public static function passwordHash(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}
