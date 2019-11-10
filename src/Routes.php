<?php

namespace Sprocketbox\Toolkit;

use Illuminate\Routing\Router;
use Sprocketbox\Toolkit\Contracts\RouteRegistrar;

/**
 * Class Routes
 *
 * Contains all of the route registrars and maps them accordingly.
 *
 * @package Sprocketbox\Toolkit
 */
class Routes
{
    /**
     * @var array
     */
    private $routes = [];

    /**
     * Register a route registrar for mapping.
     *
     * @param \Sprocketbox\Toolkit\Contracts\RouteRegistrar $routes
     * @param string                                        $group
     *
     * @return \Sprocketbox\Toolkit\Routes
     */
    public function register(RouteRegistrar $routes, $group = 'default'): self
    {
        $this->routes[$group][] = $routes;

        return $this;
    }

    /**
     * @param \Illuminate\Routing\Router $router
     * @param string                     $group
     *
     * @return $this
     */
    public function map(Router $router, $group = 'default'): self
    {
        // Here we're going to convert the array to a collection and cycle through
        // it mapping with the router instance
        collect($this->routes[$group] ?? [])
            ->each(static function (RouteRegistrar $routeRegistrar) use ($router) {
                $routeRegistrar->map($router);
            });
        return $this;
    }
}
