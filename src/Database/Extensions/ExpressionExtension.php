<?php

namespace Sprocketbox\Toolkit\Database\Extensions;

use Sprocketbox\Toolkit\Database\Expressions\Alias;
use Sprocketbox\Toolkit\Database\Expressions\Coalesce;
use Sprocketbox\Toolkit\Database\Expressions\Concat;
use Sprocketbox\Toolkit\Database\Expressions\DateFormat;
use Sprocketbox\Toolkit\Database\Expressions\GroupConcat;
use Sprocketbox\Toolkit\Database\Expressions\MultiTable;

class ExpressionExtension
{
    public function alias($value, string $alias): Alias
    {
        return new Alias($value, $alias);
    }

    public function coalesce(...$values): Coalesce
    {
        return new Coalesce(...$values);
    }

    public function concat(): Concat
    {
        return new Concat;
    }

    public function dateFormat(string $column, string $format): DateFormat
    {
        return new DateFormat($column, $format);
    }

    public function groupConcat($value): GroupConcat
    {
        return new GroupConcat($value);
    }

    public function multiTable(): MultiTable
    {
        return new MultiTable;
    }
}