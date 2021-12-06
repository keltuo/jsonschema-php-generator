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
 *
 * @package JsonSchemaPhpGenerator
 */
class ErrorWrapper implements ErrorWrapperInterface, Arrayable, ArrayAccess, Iterator, Countable
{
    /** @var class-string */
    protected string $errorModel = ErrorModel::class;
    protected array $errors = [];
    private int $position;

    /**
     * ErrorWrapper constructor.
     *
     * @throws \ReflectionException
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

    /**
     * @throws \ReflectionException
     */
    public function setErrors(array $errors): ErrorWrapperInterface
    {
        foreach ($errors as $error) {
            $this->errors[] = $error instanceof $this->errorModel ? $error : $this->createError($error);
        }

        return $this;
    }

    /**
     * @throws \ReflectionException
     */
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

    /**
     * @phpstan-ignore-next-line
     */
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->errors[$offset]);
    }

    /**
     * @phpstan-ignore-next-line
     */
    public function offsetGet(mixed $offset): ?ErrorModel
    {
        return $this->errors[$offset] ?? null;
    }

    /**
     * @phpstan-ignore-next-line
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (\is_null($offset)) {
            $this->errors[] = $value;
        } else {
            $this->errors[$offset] = $value;
        }
    }

    /**
     * @phpstan-ignore-next-line
     */
    public function offsetUnset(mixed $offset): void
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
        return \count($this->getErrors());
    }
}
