<?php

namespace Src\Core\Router;

class RouteWildcard
{
    private const WILDCARDS = [
        "(:numeric)" => "[0-9]+",
        "(:alpha)" => "[a-zA-Z]+",
        "(:any)" => "[a-zA-Z0-9\-]+"
    ];

    public static function paramsToArray($request, string $route, ?array $aliases = null): array
    {
        $routeExploded = explode("/", ltrim($route, "/"));
        $requestExploded = explode("/", ltrim($request, "/"));
        $routeAndRequestDiff = array_diff($requestExploded, $routeExploded);
        $params = [];

        foreach($routeAndRequestDiff as $index => $param) {
            if(empty($aliases)) {
                $params[] = $param;
            }
        }

        return $params;
    }

    public static function uriEqualToPattern($currentUri, $wildcardReplaced): bool
    {
        $pattern = str_replace("/", '\/', ltrim($wildcardReplaced, "/"));
        return preg_match("/^$pattern$/", ltrim($currentUri, "/"));
    }

    public static function replaceWildcard(string $uriToReplace): string
    {
        $wildcardReplaced = $uriToReplace;
        foreach (self::WILDCARDS as $wildcard => $pattern) {
            $wildcardReplaced = str_replace($wildcard, $pattern, $wildcardReplaced);
        }

        return $wildcardReplaced;
    }
}