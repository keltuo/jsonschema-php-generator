<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Model\Property;

use JetBrains\PhpStorm\Pure;

/**
 * Class BooleanProperty
 *
 * @package JsonSchemaPhpGenerator\Model\Property
 * The boolean type matches only two special values: true and false.
 * Note that values that evaluate to true or false,
 * such as 1 and 0, are not accepted by the schema.
 */
class BooleanProperty extends AbstractProperty
{
    public function getType(): string
    {
        return 'boolean';
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
