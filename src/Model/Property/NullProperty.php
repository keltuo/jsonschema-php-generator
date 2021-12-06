<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Model\Property;

use JetBrains\PhpStorm\Pure;

/**
 * Class NullProperty
 *
 * @package JsonSchemaPhpGenerator\Model\Property
 * When a schema specifies a type of null, it has only one acceptable value: null.
 */
class NullProperty extends AbstractProperty
{
    public function getType(): string
    {
        return 'null';
    }

    public function toArray(): array
    {
        return [
            'type' => $this->getType(),
        ];
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
