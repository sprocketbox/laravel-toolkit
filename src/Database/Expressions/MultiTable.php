<?php

namespace Sprocketbox\Toolkit\Database\Expressions;

class MultiTable extends Expression
{
    /**
     * @var array
     */
    protected array $tables = [];

    public function __construct()
    {
        parent::__construct('');
    }

    public function addTable($table): MultiTable
    {
        $this->tables[] = $table;

        return $this;
    }

    public function getValue()
    {
        $value = '';
        foreach ($this->tables as $table) {
            $value .= (string) $table . ', ';
        }

        return substr($value, 0, -2);
    }
}