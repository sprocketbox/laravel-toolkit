<?php

namespace Sprocketbox\Toolkit\Database\Casts;

use Carbon\CarbonInterval;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class IntervalCast implements CastsAttributes
{
    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string                              $key
     * @param mixed                               $value
     * @param array                               $attributes
     *
     * @return mixed|void
     * @throws \Exception
     */
    public function get($model, string $key, $value, array $attributes): CarbonInterval
    {
        return new CarbonInterval($value);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string                              $key
     * @param CarbonInterval                      $value
     * @param array                               $attributes
     *
     * @return string
     */
    public function set($model, string $key, $value, array $attributes): string
    {
        return $value->spec();
    }
}