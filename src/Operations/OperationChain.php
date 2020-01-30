<?php

namespace Sprocketbox\Toolkit\Operations;

use Closure;
use InvalidArgumentException;

class OperationChain
{
    /**
     * @var \Sprocketbox\Toolkit\Operations\Contracts\Operation
     */
    protected Contracts\Operation $operation;

    protected array               $operations = [];

    protected Closure             $predicate;

    protected Closure             $errorHandler;

    public function __construct(Contracts\Operation $operation)
    {
        $this->operation = $operation;
    }

    public function where(Closure $predicate): self
    {
        $this->predicate = $predicate;

        return $this;
    }

    public function whereTruthy(): self
    {
        $this->predicate = fn($value): bool => $value !== null && (bool) $value;

        return $this;
    }

    public function error(Closure $errorHandler): self
    {
        $this->errorHandler = $errorHandler;

        return $this;
    }

    public function then($operation): self
    {
        $this->operations[] = $operation;

        return $this;
    }

    public function when(callable $condition, $operation): self
    {
        $this->operations[] = [$condition, $operation];

        return $this;
    }

    public function run(array $results = [])
    {
        $results[] = $result = $this->operation->perform();

        if ($this->checkResult($result)) {
            foreach ($this->operations as $next) {
                if ($this->next($next, $results) === false) {
                    return call_user_func($this->errorHandler, $next, $result, $results);
                }
            }

            return $result;
        }

        return null;
    }

    protected function next($next, array $results): bool
    {
        return $this->checkResult($this->performOperation($next, $results));
    }

    protected function performOperation($operation, array $results)
    {
        if ($operation instanceof Contracts\Operation) {
            return $operation->perform();
        }

        if ($operation instanceof self) {
            return $operation->run($results);
        }

        if ($operation instanceof Closure) {
            $result = $operation(...array_reverse($results));

            if ($results instanceof Contracts\Operation) {
                return $this->performOperation($operation, $results);
            }

            return $result;
        }

        if (is_array($operation)) {
            [$condition, $operation] = $operation;

            if (! is_callable($condition)) {
                throw new InvalidArgumentException('Operation condition must be callable');
            }

            if ($condition(...array_reverse($results))) {
                return $this->performOperation($operation, $results);
            }

            return true;
        }

        return null;
    }

    private function checkResult($result): bool
    {
        return ! isset($this->predicate) || call_user_func($this->predicate, $result);
    }
}