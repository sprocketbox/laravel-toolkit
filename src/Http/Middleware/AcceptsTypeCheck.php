<?php

namespace Sprocketbox\Toolkit\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Sprocketbox\Toolkit\Exceptions\UnsupportedAcceptMediaTypeException;

class AcceptsTypeCheck
{
    public function handle(Request $request, Closure $next, array $types)
    {
        if (! $request->accepts($types)) {
            throw new UnsupportedAcceptMediaTypeException;
        }

        return $next($request);
    }
}