<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Model\Property;

use JetBrains\PhpStorm\Pure;
use JsonSchemaPhpGenerator\Model\ModelInterface;

/**
 * Class AbstractProperty
 *
 * @package JsonSchemaPhpGenerator\Model\Property
 */
abstract class AbstractProperty implements ModelInterface, \JsonSerializable, \Stringable
{
    abstract public function getType(): string;

    abstract public function toArray(): array;

    public function __construct(
        public string $name,
        public string $description = '',
    ) {
    }

    #[Pure]
    public function getIdentifier(): string
    {
        return $this->getName();
    }

    public function getName(): string
    {
        return $this->name;
    }

    #[Pure]
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function __toString(): string
    {
        return (string)\json_encode($this);
    }
}
