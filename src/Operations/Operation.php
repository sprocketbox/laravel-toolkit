<?php

namespace Sprocketbox\Toolkit\Operations;

use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;
use InvalidArgumentException;

abstract class Operation implements Contracts\Operation
{
    /**
     * @return static
     */
    public static function start(): self
    {
        try {
            return Container::getInstance()->make(__CLASS__, func_get_args());
        } catch (BindingResolutionException $e) {
            report($e);
        }
    }

    /**
     * Handle any calls to setters.
     *
     * Match the called setter name to a property name.
     *
     * @param $name
     * @param $arguments
     *
     * @return $this
     */
    public function __call($name, $arguments)
    {
        // Error if there are no arguments provided
        if (count($arguments) === 0) {
            throw new InvalidArgumentException('Must provide a property value');
        }

        // If the property doesn't exist we're going to want to error
        // There's no nice way to check if a property is actually accessible without using reflection
        // which is a bit overkill here, so we're going to let it error naturally
        if (! property_exists($this, $name)) {
            throw new InvalidArgumentException('Invalid operation property');
        }

        $this->$name = count($arguments) === 1 ? $arguments[0] : $arguments;

        return $this;
    }

    public function then($operation): OperationChain
    {
        return (new OperationChain($this))->then($operation);
    }

    public function when(callable $condition, $operation): OperationChain
    {
        return (new OperationChain($this))->when($condition, $operation);
    }
}