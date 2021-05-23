<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Model\Property;


use JetBrains\PhpStorm\Pure;
use JsonSchemaPhpGenerator\Model\ModelInterface;

/**
 * Class AbstractProperty
 * @package JsonSchemaPhpGenerator\Model\Property
 */
abstract class AbstractProperty implements ModelInterface,\JsonSerializable, \Stringable
{
    public function __construct(
        public string $name,
        public string $description = '',
    ){}

    abstract public function getType(): string;

    #[Pure]
    public function getIdentifier(): string
    {
        return $this->getName();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function __toString(): string
    {
        return (string)json_encode($this);
    }

    abstract public function toArray(): array;

    #[Pure]
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
