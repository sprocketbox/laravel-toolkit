<?php

namespace Sprocketbox\Toolkit\Database\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class UUIDCast implements CastsAttributes
{
    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string                              $key
     * @param string                              $value
     * @param array                               $attributes
     *
     * @return \Ramsey\Uuid\UuidInterface
     */
    public function get($model, string $key, $value, array $attributes): UuidInterface
    {
        return Uuid::fromString($value);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string                              $key
     * @param \Ramsey\Uuid\UuidInterface          $value
     * @param array                               $attributes
     *
     * @return string
     */
    public function set($model, string $key, $value, array $attributes): string
    {
        return $value->toString();
    }
}