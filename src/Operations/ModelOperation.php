<?php

namespace Sprocketbox\Toolkit\Operations;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ModelOperation
 *
 * @package Sprocketbox\Toolkit\Operations
 */
abstract class ModelOperation extends Operation
{
    /**
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    abstract protected function getModel(): ?Model;

    /**
     * @return array
     */
    abstract protected function getAttributes(): array;

    /**
     * @param array                               $attributes
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    abstract protected function validate(array $attributes, Model $model): void;
}