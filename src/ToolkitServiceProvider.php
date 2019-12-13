<?php

namespace Sprocketbox\Toolkit;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Sprocketbox\Toolkit\Http\Middleware\AcceptsTypeCheck;
use Sprocketbox\Toolkit\Http\Middleware\EnforcesJson;

class ToolkitServiceProvider extends ServiceProvider
{
    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function register()
    {
        $this->app->make(Router::class)
            ->aliasMiddleware('toolkit.accepts', AcceptsTypeCheck::class)
            ->aliasMiddleware('toolkit.expects', AcceptsTypeCheck::class)
            ->aliasMiddleware('toolkit.json', EnforcesJson::class);
    }
}