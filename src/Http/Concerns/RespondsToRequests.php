<?php /** @noinspection PhpInconsistentReturnPointsInspection */

namespace Sprocketbox\Toolkit\Http\Concerns;

use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Http\Request;

/**
 * RespondsToRequests Concern
 *
 * Provides response functionality for actions & controllers.
 *
 * @package Sprocketbox\Toolkit\Concerns
 */
trait RespondsToRequests
{
    /**
     * @var \Illuminate\Http\Request|null
     */
    private ?Request $request;

    /**
     * Create and return a new factory for building a response.
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory
     */
    protected function response(): ResponseFactory
    {
        try {
            return Container::getInstance()->make(ResponseFactory::class);
        } catch (BindingResolutionException $exception) {
            report($exception);
        }
    }

    /**
     * Get the current request.
     *
     * @return \Illuminate\Http\Request
     */
    protected function request(): Request
    {
        try {
            if ($this->request === null) {
                $this->request = Container::getInstance()->make(Request::class);
            }

            return $this->request;
        } catch (BindingResolutionException $exception) {
            report($exception);
        }
    }

    /**
     * Get the URL generator.
     *
     * @return \Illuminate\Contracts\Routing\UrlGenerator
     */
    protected function url(): UrlGenerator
    {
        try {
            return Container::getInstance()->make(UrlGenerator::class);
        } catch (BindingResolutionException $exception) {
            report($exception);
        }
    }
}
