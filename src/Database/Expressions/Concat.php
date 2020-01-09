<?php

namespace Sprocketbox\Toolkit\Database\Expressions;

class Concat extends Expression
{
    protected array $parts = [];

    public function __construct()
    {
        parent::__construct('');
    }

    public function addExpression(Expression $expression): Concat
    {
        $this->parts[] = $expression;

        return $this;
    }

    public function addString(string $string): Concat
    {
        $this->parts[] = '"' . $string . '"';

        return $this;
    }

    public function addColumn(string $column): Concat
    {
        $this->parts[] = $this->wrapColumN($column);

        return $this;
    }

    public function getValue()
    {
        return 'CONCAT(' . implode(',', $this->parts) . ')';
    }
}