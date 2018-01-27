<?php

require_once ROOT . '/core/Response.php';

class Router {
    private static $routes = array(
        "GET" => array(),
        "POST" => array()
    );

    private static $request = array();
    private static $response = null;

    public static function get($pattern, $callback)
    {
        self::$routes["GET"][$pattern] = $callback;
    }

    public static function post($pattern, $callback)
    {
        self::$routes["POST"][$pattern] = $callback;
    }

    public static function run()
    {
        $url = self::$request["url"] = self::getURL();
        $method = self::$request["method"] = $_SERVER["REQUEST_METHOD"];
        self::$response = new Response();

        foreach(self::$routes[$method] as $pattern => $callback)
        {
            if (preg_match("~$pattern~", $url, $matches))
            {
                self::getParams($matches);
                call_user_func($callback, self::$request, self::$response);
            }
        }

        self::$response->http404();
    }

    private static function getParams($matches)
    {
        foreach($matches as $key => $value)
        {
            if (is_string($key))
                self::$request["params"][$key] = $value;
        }
    }

    private static function getURL()
    {
        $uri = preg_replace("/\?.*/", "", $_SERVER["REQUEST_URI"]);
        return trim($uri, "/");
    }
}
