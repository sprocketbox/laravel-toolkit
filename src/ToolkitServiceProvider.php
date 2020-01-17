<?php

namespace Sprocketbox\Toolkit;

use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\Grammars\MySqlGrammar as BaseMysqlGrammar;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Sprocketbox\Toolkit\Database\Extensions\ExpressionExtension;
use Sprocketbox\Toolkit\Database\Grammar\MysqlGrammar;
use Sprocketbox\Toolkit\Http\Middleware\AcceptsTypeCheck;
use Sprocketbox\Toolkit\Http\Middleware\EnforcesJson;

class ToolkitServiceProvider extends ServiceProvider
{
    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function register(): void
    {
        $this->registerMiddleware();
        $this->registerGrammarOverride();
        $this->registerBuilderExtensions();
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function registerMiddleware(): void
    {
        $this->app->make(Router::class)
            ->aliasMiddleware('toolkit.accepts', AcceptsTypeCheck::class)
            ->aliasMiddleware('toolkit.expects', AcceptsTypeCheck::class)
            ->aliasMiddleware('toolkit.json', EnforcesJson::class);
    }

    private function registerGrammarOverride(): void
    {
        $this->app['db']->extend('mysql', function (array $config, string $name) {
            /**
             * @var \Illuminate\Database\Connection $connection
             */
            $connection = $this->app['db.factory']->make($config, $name);

            if ($connection !== null && $connection->getQueryGrammar() instanceof BaseMysqlGrammar) {
                $connection->setQueryGrammar(new MysqlGrammar);
            }
        });
    }

    private function registerBuilderExtensions(): void
    {
        //Builder::mixin(new ExpressionExtension);
    }
}