<?php

namespace system;

use system\components\Utils;
use system\exceptions\InvalidRouteException;


/**
 * Get URL, find correct route and call controller methods matching route
 * Class Router
 * @package system
 */
class Router
{
    /**
     * Routes table
     * @var array $routes [match, route[]]
     */
    private static $routes = [];

    /**
     * Current route
     * @var array $route [controller, action, params[]]
     */
    protected static $route = [];

    /**
     * Is the current request ajax
     * @var bool
     */
    private static $isAjax = false;

    /**
     * Add new route to routes table
     * @param string $regexp regexp of the route
     * @param array $route route[controller, action, params[]]
     */
    public static function add($regexp, array $route = [])
    {
        self::$routes[$regexp] = $route;
    }

    /**
     * Find matching route for requested URL
     * @param $url
     * @return array|mixed $route[controller, action, params[]]
     */
    public static function matchRoute($url)
    {
        $route = [];
        foreach (self::$routes as $pattern => $route) {
            if (preg_match("#$pattern#", $url, $matches)) {
                foreach ($matches as $k => $v) {
                    if (is_string($k) && !(isset($route[$k]))) {
                        $route[$k] = $v;
                    }
                }
                if (!isset($route['controller'])) {
                    $route['controller'] = 'home';
                }
                if (!isset($route['action'])) {
                    $route['action'] = 'index';
                }
                break;
            }
        }
        return $route;
    }

    /**
     * Find and create controller and call methods from matching route
     * @param string $url
     */
    public static function dispatch($url)
    {
        $route = [];
        try {
            self::$isAjax = self::isAjax();
            $url = self::removeQueryString($url);
            self::$route = self::matchRoute($url);
            if (empty(self::$route)) {
                throw new InvalidRouteException('Unable to resolve request');
            }
            self::$route['controller'] = Utils::upperCamelCase(self::$route['controller']);
            self::$route['action'] = Utils::lowerCamelCase(self::$route['action']);
            // Namespace of controller
            $controller = 'app\controller\\' . self::$route['controller'];
            // Check if request is ajax to call right methods in controller
            if (self::$isAjax) {
                $actionName = 'ajax' . self::$route['action'];
            } else {
                $actionName = self::$route['action'] . 'Action';
            }
            if (!class_exists($controller)) {
                throw new InvalidRouteException("Unable to find controller $controller");
            }
            $cObj = new $controller(self::$route);
            if (!method_exists($cObj, $actionName)) {
                throw new InvalidRouteException("Unable to find action $actionName in $controller");
            }
            if (method_exists($cObj, 'init') && !self::$isAjax) {
                $cObj->init();
            }
            $cObj->$actionName();
            // Dont show views for ajax requests
            if (!self::$isAjax) {
                $cObj->getView();
            }
        } catch (InvalidRouteException $e) {
            $e->showNotFoundPage();
        }
    }

    /**
     * Remove all GET params from URL
     * @param string $url
     * @return string $url
     */
    private static function removeQueryString($url)
    {
        if ($url) {
            $url = trim($url, '/');
            $params = explode('?', $url, 2);
            return rtrim($params[0], '/');
        }
        return $url;
    }

    /**
     * Is the request ajax
     * @return bool
     */
    private static function isAjax()
    {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Redirect
     * @param $url
     */
    public static function createRedirectPath($url)
    {
        header("Location: {$url}");
        exit();
    }
}