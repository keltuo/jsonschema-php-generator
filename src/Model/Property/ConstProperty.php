<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Model\Property;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

/**
 * Class ConstProperty
 * @package JsonSchemaPhpGenerator\Model\Property
 * The const keyword is used to restrict a value to a single value.
 */
class ConstProperty extends AbstractProperty
{
    #[Pure]
    public function __construct(
        string $name,
        protected string|bool $value,
        string $description = '',
    )
    {
        parent::__construct($name, $description);
    }

    public function getValue(): string|bool
    {
        return $this->value;
    }

    public function getType(): string
    {
        return 'const';
    }

    public function __toString(): string
    {
        return (string)json_encode($this);
    }

    #[ArrayShape(['const' => "bool|string"])]
    public function toArray(): array
    {
        return [
            'const' => $this->getValue()
        ];
    }

    #[ArrayShape(['const' => "bool|string"])]
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
