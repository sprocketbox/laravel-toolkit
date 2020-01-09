<?php

namespace Sprocketbox\Toolkit\Database\Expressions;

class GroupConcat extends Expression
{
    public function __construct($value)
    {
        parent::__construct($this->wrapColumn($value));
    }

    public function getValue()
    {
        return 'GROUP_CONCAT(' . parent::getValue() . ')';
    }
}