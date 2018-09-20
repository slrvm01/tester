<?php

namespace system;

use App;


/**
 * Class Application
 * @package system
 */
class Application
{
    /**
     * Application constructor.
     */
    public function __construct()
    {
        App::$app = $this;
        $this->init();
    }

    /**
     * Application initialization.
     * Adding default routes from config and send requested URL to Router
     */
    private function init()
    {
        $this->addDefaultRoutes();
        Router::dispatch($_SERVER['REQUEST_URI']);
    }

    /**
     * Adding default routes from config
     */
    private function addDefaultRoutes()
    {
        $routes = unserialize(ROUTES);
        foreach ($routes as $route) {
            if (isset($route['route'])) {
                Router::add($route['match'], $route['route']);
            } else {
                Router::add($route['match']);
            }
        }
    }
}