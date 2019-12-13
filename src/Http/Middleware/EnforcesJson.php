<?php

namespace Sprocketbox\Toolkit\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException;

/**
 * EnforcesJson Middleware
 *
 * This middleware will enforce both a JSON content type and accept.
 *
 * @package Sprocketbox\Toolkit\Http\Middleware
 */
class EnforcesJson
{
    /**
     * The names of routes that are exempt. Also supports patterns.
     *
     * @var array
     */
    private array   $exempt      = [];

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (! $request->routeIs($this->exempt)) {
            // If the content type override isn't set and the content isn't JSON, throw the exception
            if (! $request->isJson()) {
                throw new UnsupportedMediaTypeHttpException;
            }

            // If no array of accept types are provided and the request doesn't accept JSON, throw
            // the exception
            if (! $request->acceptsJson()) {
                throw new UnsupportedMediaTypeHttpException;
            }
        }

        return $next($request);
    }
}