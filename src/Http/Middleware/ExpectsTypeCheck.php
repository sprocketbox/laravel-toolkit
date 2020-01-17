<?php

namespace Sprocketbox\Toolkit\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Sprocketbox\Toolkit\Exceptions\UnsupportedContentTypeException;

class ExpectsTypeCheck
{
    public function handle(Request $request, Closure $next, array $types)
    {
        if (! Str::is($types, $request->getContentType())) {
            throw new UnsupportedContentTypeException;
        }

        return $next($request);
    }
}