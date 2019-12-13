<?php

namespace Sprocketbox\Toolkit\Http\Contracts;

/**
 * Interface Operation
 *
 * An operation is an abstracted piece of functionality.
 *
 * @package Sprocketbox\Toolkit\Contracts
 */
interface Operation
{
    /**
     * Perform the operation.
     *
     * @return mixed
     */
    public function perform();
}