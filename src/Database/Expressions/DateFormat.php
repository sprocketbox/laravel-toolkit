<?php

namespace Sprocketbox\Toolkit\Database\Expressions;

class DateFormat extends Expression
{
    /**
     * @var string
     */
    protected string $column;

    /**
     * @var string
     */
    protected string $format;

    public function __construct(string $column, string $format)
    {
        parent::__construct('');
        $this->column = $column;
        $this->format = $format;
    }

    public function getValue()
    {
        return 'DATE_FORMAT(' . $this->wrapColumn($this->column) . ', "' . $this->format . '")';
    }
}