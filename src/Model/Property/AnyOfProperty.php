<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Model\Property;

use JetBrains\PhpStorm\Pure;
use JsonSchemaPhpGenerator\Model\PropertyBag;

/**
 * Class AnyOfProperty
 *
 * @package JsonSchemaPhpGenerator\Model\Property
 */
class AnyOfProperty extends AbstractProperty
{
    #[Pure]
    public function __construct(
        string $name,
        protected PropertyBag $propertyBag,
        string $description = '',
    )
    {
        parent::__construct($name, $description);
    }

    public function getType(): string
    {
        return 'anyOf';
    }

    public function toArray(): array
    {
        $data = [];

        foreach ($this->propertyBag->getItems() as $property) {
            /** @var AbstractProperty $property */
            $data[] = $property->toArray();
        }

        return [$this->getType() => $data];
    }
}
