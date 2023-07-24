<?php

namespace Source\Core;

final class Helpers
{
    final private function __construct()
    {
    }

    public static function baseUrl(string $subpath = null): string
    {
        return CONF_BASE_URL . preg_replace("/\/+/i", "/", $subpath);
    }
}
