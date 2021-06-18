<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Model;


use JsonSchemaPhpGenerator\Model\Property\AbstractProperty;
use JsonSchemaPhpGenerator\Model\Property\ArrayProperty;
use JsonSchemaPhpGenerator\Model\Property\BooleanProperty;
use JsonSchemaPhpGenerator\Model\Property\ConstProperty;
use JsonSchemaPhpGenerator\Model\Property\EnumProperty;
use JsonSchemaPhpGenerator\Model\Property\Format\AbstractFormat;
use JsonSchemaPhpGenerator\Model\Property\IntegerProperty;
use JsonSchemaPhpGenerator\Model\Property\Length;
use JsonSchemaPhpGenerator\Model\Property\LengthItems;
use JsonSchemaPhpGenerator\Model\Property\MultipleTypeProperty;
use JsonSchemaPhpGenerator\Model\Property\NullProperty;
use JsonSchemaPhpGenerator\Model\Property\NumberProperty;
use JsonSchemaPhpGenerator\Model\Property\Range;
use JsonSchemaPhpGenerator\Model\Property\ReferenceProperty;
use JsonSchemaPhpGenerator\Model\Property\StringProperty;

/**
 * Class PropertyBag
 * @package JsonSchemaPhpGenerator\Model
 */
class PropertyBag extends AbstractBag
{
    public function add(AbstractProperty $property): PropertyBag
    {
        if (empty($property->name)) {
            $property->name = (string)(count($this->items)+1);
        }
        $this->insertEntry($property);
        return $this;
    }

    public function addString(
        string $name,
        string $description = '',
        ?AbstractFormat $format = null,
        ?Length $length = null,
        ?string $regex = null
    ): PropertyBag
    {
        $item = new StringProperty($name, $description, $format, $length, $regex);
        $this->add($item);
        return $this;
    }

    public function addNumber(
        string $name,
        string $description = '',
        ?Range $range = null,
        ?int $multipleOf = null
    ): PropertyBag
    {
        $item = new NumberProperty($name, $description, $range, $multipleOf);
        $this->add($item);
        return $this;
    }

    public function addInt(
        string $name,
        string $description = '',
        ?Range $range = null,
        ?int $multipleOf = null
    ): PropertyBag
    {
        $item = new IntegerProperty($name, $description, $range, $multipleOf);
        $this->add($item);
        return $this;
    }

    public function addBool(
        string $name,
        string $description = ''
    ): PropertyBag
    {
        $item = new BooleanProperty($name, $description);
        $this->add($item);
        return $this;
    }

    public function addNull(
        string $name,
        string $description = ''
    ): PropertyBag
    {
        $item = new NullProperty($name, $description);
        $this->add($item);
        return $this;
    }

    public function addArray(
        string $name,
        ItemBag $itemBag,
        string $description = '',
        ?LengthItems $lengthItems = null,
        string $default = '',
        ?bool $uniqueItems = null,
        ?bool $additionalItems = null,
    ): PropertyBag
    {
        $item = new ArrayProperty(
            $name,
            $description,
            $lengthItems,
            $default,
            $uniqueItems,
            $additionalItems
        );
        $item->setItemBag($itemBag);
        $this->add($item);
        return $this;
    }

    public function addReference(
        string $name,
        string $identifier,
        string $description = '',
    ): PropertyBag
    {
        $item = new ReferenceProperty($name, $description, $identifier);
        $this->add($item);
        return $this;
    }

    public function addEnum(
        string $name,
        array $items,
        string $default = '',
        string $description = '',
    ): PropertyBag
    {
        $item = new EnumProperty($name, $items, $default, $description);
        $this->add($item);
        return $this;
    }

    public function addMultipleType(string $name, PropertyBag $propertyBag, string $description = ''): PropertyBag
    {
        $item = new MultipleTypeProperty( $name, $description);
        $item->setPropertyBag($propertyBag);
        $this->add($item);
        return $this;
    }

    public function addConst(
        string $name,
        string|bool $value,
        string $description = ''
    ): PropertyBag
    {
        $item = new ConstProperty($name, $value, $description);
        $this->add($item);
        return $this;
    }

    public function toArray(): array
    {
        $output = [];
        foreach ($this->items as $item) {
            $output[$item->getName()] = $item->toArray();
        }
        return $output;
    }
}
