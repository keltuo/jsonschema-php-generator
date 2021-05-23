<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Model\Property;


use JetBrains\PhpStorm\Pure;
use JsonSchemaPhpGenerator\Model\PropertyBag;

/**
 * Class MultipleTypeProperty
 * @package JsonSchemaPhpGenerator\Model\Property
 */
class MultipleTypeProperty extends AbstractProperty
{
    protected PropertyBag $propertyBag;
    #[Pure]
    public function __construct(
        string $name,
        string $description = '',
    )
    {
       parent::__construct($name, $description);
       $this->propertyBag = new PropertyBag();
    }

    public function getType(): string
    {
        return 'multiple';
    }

    public function getPropertyBag(): PropertyBag
    {
        return $this->propertyBag;
    }

    public function setPropertyBag(PropertyBag $propertyBag): MultipleTypeProperty
    {
        $this->propertyBag = $propertyBag;
        return $this;
    }

    public function addItemToBag(AbstractProperty $property): MultipleTypeProperty
    {
        $this->getPropertyBag()->add($property);
        return $this;
    }

    public function toArray(): array
    {
        return [
            'type' => array_map(
                fn(AbstractProperty $item):
                    string => $item->getType(),
                    $this->getPropertyBag()->getItems()
            )
        ];
    }
}
