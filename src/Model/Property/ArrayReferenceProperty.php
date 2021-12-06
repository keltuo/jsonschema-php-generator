<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Model\Property;

use JetBrains\PhpStorm\Pure;

/**
 * Class ArrayReferenceProperty
 *
 * @package JsonSchemaPhpGenerator\Model\Property
 */
class ArrayReferenceProperty extends ArrayProperty
{
    #[Pure]
    public function __construct(
        string $name,
        string $description = '',
        protected string $identifier = '',
        ?LengthItems $lengthItems = null,
        string $default = '',
        ?bool $uniqueItems = null,
        ?bool $additionalItems = null,
    )
    {
        parent::__construct(
            $name,
            $description,
            $lengthItems,
            $default,
            $uniqueItems,
            $additionalItems
        );
    }

    public function toArray(): array
    {
        return \array_merge(parent::toArray(), ['items' => ['$ref' => $this->identifier]]);
    }
}
