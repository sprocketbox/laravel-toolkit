<?php

namespace Sprocketbox\Toolkit\Operations;

use Closure;
use Illuminate\Database\DatabaseManager;
use InvalidArgumentException;

/**
 * Class TransactionalOperation
 *
 * @method self callback(Closure $transaction)
 * @method self connection(string $connection)
 * @method self attempts(int $attempts)
 *
 * @package Sprocketbox\Toolkit\Operations
 */
final class TransactionalOperation extends Operation
{
    protected ?Closure $callback   = null;

    protected ?string  $connection = null;

    protected int      $attempts   = 1;

    /**
     * @var \Illuminate\Database\DatabaseManager
     */
    protected DatabaseManager $databaseManager;

    public function __construct(DatabaseManager $databaseManager)
    {
        $this->databaseManager = $databaseManager;
    }

    /**
     * @return mixed
     * @throws \Throwable
     */
    public function perform()
    {
        if ($this->callback === null) {
            throw new InvalidArgumentException('No transaction body provided');
        }

        return $this->databaseManager
            ->connection($this->connection)
            ->transaction($this->callback, $this->attempts);
    }
}