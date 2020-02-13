<?php

namespace Sprocketbox\Toolkit\Validators\Rules;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\Unique;

class Rules
{
    /**
     * @param \Illuminate\Database\Eloquent\Model|string $model
     * @param string|null                                $column
     *
     * @return \Illuminate\Validation\Rules\Unique
     */
    public static function unique($model, ?string $column = null): Unique
    {
        $instance = $model instanceof Model ? $model : new $model;
        $rule     = new Unique($instance->getTable(), $column ?? 'NULL');

        if ($model instanceof Model) {
            $rule->ignoreModel($model);
        }

        return $rule;
    }

    public static function password(?string $guard = null): UserPassword
    {
        return new UserPassword($guard);
    }
}