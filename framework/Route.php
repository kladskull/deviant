<?php declare(strict_types=1); // strict mode

/**
 * Created by PhpStorm.
 * User: mcurry
 * Date: 9/28/17
 * Time: 10:48 PM
 */

/*
final class Route
{
    private static $routes = [];

    private function __construct()
    {
    }

    public static function controller(string $base_uri, string $class_name)
    {
        static::$routes[$base_uri] = $class_name;
    }

    public static function showRoutes()
    {
        foreach (static::$routes as $base_uri => $class_name) {
            echo $base_uri . ' => ' . $class_name, PHP_EOL;
        }
    }

    public static function validateRoute(string $base_uri): bool
    {
        $controller_exists = false;
        if (!empty(static::$routes[$base_uri])) {
            $controller_exists = true;
        }

        return $controller_exists;
    }

    public static function getRouteObject(string $base_uri): string
    {
        $route_object = null;
        if (!empty(static::$routes[$base_uri])) {
            $route_object = (string)static::$routes[$base_uri];
        }

        return $route_object;
    }
}
*/