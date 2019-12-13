<?php

namespace Sprocketbox\Toolkit\Http\Contracts;

use Illuminate\Routing\Router;

/**
 * Interface RouteRegistrar
 *
 * The route registrar is used to map/define application routes.
 *
 * @package Sprocketbox\Toolkit\Contracts
 */
interface RouteRegistrar
{
    /**
     * Map/Define the routes on the router.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function map(Router $router): void;
}
