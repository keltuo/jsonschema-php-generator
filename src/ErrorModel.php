<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator;

use JetBrains\PhpStorm\ArrayShape;
use JsonSerializable;
use Stringable;

class ErrorModel implements Arrayable, JsonSerializable, Stringable
{
    protected string $property = '';
    protected string $pointer = '';
    protected string $message = '';
    protected array $constraint = [];
    protected int $context = 0;

    /**
     * ErrorModel constructor.
     */
    public function __construct(array $data = [])
    {
        if (\count($data) <= 0) {
            return;
        }

        foreach (self::toArray() as $key => $value) {
            if (\array_key_exists($key, $data)) {
                $this->{$key} = $data[$key];
            }
        }
    }

    public function getProperty(): string
    {
        return $this->property;
    }

    public function setProperty(string $property): ErrorModel
    {
        $this->property = $property;
        return $this;
    }

    public function getPointer(): string
    {
        return $this->pointer;
    }

    public function setPointer(string $pointer): ErrorModel
    {
        $this->pointer = $pointer;
        return $this;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): ErrorModel
    {
        $this->message = $message;
        return $this;
    }

    public function getConstraint(): array
    {
        return $this->constraint;
    }

    public function setConstraint(array $constraint): ErrorModel
    {
        $this->constraint = $constraint;
        return $this;
    }

    public function getContext(): int
    {
        return $this->context;
    }

    public function setContext(int $context): ErrorModel
    {
        $this->context = $context;
        return $this;
    }


    #[ArrayShape([
        'property' => "string",
        'pointer' => "string",
        'message' => "string",
        'constraint' => "array",
        'context' => "int",
    ])]
    public function toArray(): array
    {
        return [
            'property' => $this->property,
            'pointer' => $this->pointer,
            'message' => $this->message,
            'constraint' => $this->constraint,
            'context' => $this->context,
        ];
    }

    #[ArrayShape([
        'property' => "string",
        'pointer' => "string",
        'message' => "string",
        'constraint' => "array",
        'context' => "int",
    ])]
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function __toString(): string
    {
        return (string)\json_encode($this);
    }
}
