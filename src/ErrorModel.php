<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator;


use JetBrains\PhpStorm\ArrayShape;
use JsonSerializable;
use Stringable;

class ErrorModel implements Arrayable, JsonSerializable, Stringable
{
    public string $property = '';
    public string $pointer = '';
    public string $message = '';
    public string $constraint = '';
    public int $context = 0;

    /**
     * ErrorModel constructor.
     * @param array<string, int|string> $data
     */
    public function __construct(array $data = [])
    {
        if (count($data) > 0) {
            foreach ($this->toArray() as $key => $value) {
                if(array_key_exists($key, $data)) {
                    $this->{$key} = $data[$key];
                }
            }
        }
    }

    /**
     * @return array<string, int|string>
     */
    #[ArrayShape([
        'property' => "string",
        'pointer' => "string",
        'message' => "string",
        'constraint' => "string",
        'context' => "int"
    ])]
    public function toArray(): array
    {
        return [
            'property' => $this->property,
            'pointer' => $this->pointer,
            'message' => $this->message,
            'constraint' => $this->constraint,
            'context' => $this->context
        ];
    }

    public function __toString(): string
    {
        return (string)json_encode($this);
    }

    #[ArrayShape([
        'property' => "string",
        'pointer' => "string",
        'message' => "string",
        'constraint' => "string",
        'context' => "int"
    ])]
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
