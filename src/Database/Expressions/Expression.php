<?php

namespace Sprocketbox\Toolkit\Database\Expressions;

use Illuminate\Database\Query\Expression as BaseExpression;

abstract class Expression extends BaseExpression
{
    protected function wrapColumn(string $column): string
    {
        return substr_count($column, '.') === 0 ? '`' . $column . '`' : $column;
    }
}