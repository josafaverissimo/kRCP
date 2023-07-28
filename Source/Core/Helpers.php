<?php

namespace Source\Core;

final class Helpers
{
    final private function __construct()
    {
    }

    public static function baseUrl(string $subpath = null): string
    {
        return preg_replace("/\/+/i", "/", CONF_BASE_URL . $subpath);
    }
}
