<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator;

use ArrayAccess;
use Countable;
use Iterator;
use JetBrains\PhpStorm\Pure;
use ReflectionClass;

/**
 * Class ErrorWrapper
 * @package JsonSchemaPhpGenerator
 */
class ErrorWrapper implements ErrorWrapperInterface, Arrayable, ArrayAccess, Iterator, Countable
{
    protected string $errorModel = ErrorModel::class;
    /** @var array|ErrorModel[] */
    protected array $errors = [];
    private int $position;

    /**
     * ErrorWrapper constructor.
     * @param array $errors
     */
    public function __construct(array $errors = [])
    {
        $this->position = 0;
        $this->setErrors($errors);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function setErrors(array $errors): ErrorWrapperInterface
    {
        foreach ($errors as $error) {
            if ($error instanceof $this->errorModel) {
                $this->errors[] = $error;
            } else {
                $this->errors[] = $this->createError($error);
            }
        }
        return $this;
    }

    public function createError(array $data = []): object
    {
        return (new ReflectionClass($this->errorModel))->newInstanceArgs([$data]);
    }

    public function toArray(): array
    {
        $output = [];
        foreach ($this->errors as $error) {
            $output[] = $error->toArray();
        }
        return $output;
    }

    public function offsetExists($offset): bool
    {
        return isset($this->errors[$offset]);
    }

    public function offsetGet($offset): ?ErrorModel
    {
        return isset($this->errors[$offset]) ? $this->errors[$offset] : null;
    }

    public function offsetSet($offset, $value): void
    {
        if (is_null($offset)) {
            $this->errors[] = $value;
        } else {
            $this->errors[$offset] = $value;
        }
    }

    public function offsetUnset($offset): void
    {
        unset($this->errors[$offset]);
    }

    public function current(): ErrorModel
    {
        return $this->errors[$this->position];
    }

    public function next(): void
    {
        ++$this->position;
    }

    public function key(): int
    {
        return $this->position;
    }

    public function valid(): bool
    {
        return isset($this->errors[$this->position]);
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    #[Pure]
    public function count(): int
    {
        return count($this->getErrors());
    }
}
