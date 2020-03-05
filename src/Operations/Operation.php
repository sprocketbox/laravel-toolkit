<?php

namespace Sprocketbox\Toolkit\Operations;

use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Str;
use InvalidArgumentException;

abstract class Operation implements Contracts\Operation
{
    /**
     * @return static
     */
    public static function start(): self
    {
        try {
            return Container::getInstance()->make(static::class, func_get_args());
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
     * @return self
     */
    public function __call($name, $arguments): self
    {
        // Error if there are no arguments provided
        if (count($arguments) === 0) {
            throw new InvalidArgumentException('Must provide a property value');
        }

        // If the property doesn't exist we're going to want to error
        // There's no nice way to check if a property is actually accessible without using reflection
        // which is overkill here, so we're going to let it error naturally
        if (! property_exists($this, $name)) {
            throw new InvalidArgumentException('Invalid operation property');
        }

        $this->$name = count($arguments) === 1 ? $arguments[0] : $arguments;

        return $this;
    }

    /**
     * Get an array of attributes using class properties, optionally skipping null entries.
     *
     * @param array<string>      $properties An array of properties to snake case and use as array keys
     * @param bool|array<string> $skipIfNull True to skip null, false to not, or an array of properties to skip if null
     *
     * @return array
     */
    protected function getPropertiesAsAttributes(array $properties, $skipIfNull = false): array
    {
        $attributes = [];

        foreach ($properties as $property) {
            $property = Str::camel($property);

            if (! property_exists($this, $property)) {
                throw new InvalidArgumentException(sprintf('Property %s on %s does not exist', self::class, $property));
            }

            if ($this->shouldSkip($property, $skipIfNull)) {
                continue;
            }

            /** @noinspection NullCoalescingOperatorCanBeUsedInspection */
            $attributes[Str::snake($property)] = isset($this->{$property}) ? $this->{$property} : null;
        }

        return $attributes;
    }

    /**
     * Check if the property should be skipped.
     *
     * @param string             $property
     * @param bool|array<string> $skipIfNull
     *
     * @return bool
     */
    private function shouldSkip(string $property, $skipIfNull = false): bool
    {
        return (! isset($this->{$property}) && $this->{$property} === null)
            && ($skipIfNull === true || (is_array($skipIfNull) && in_array($property, $skipIfNull, true)));
    }
}