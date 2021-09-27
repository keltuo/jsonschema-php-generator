<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Model;

use JsonSchemaPhpGenerator\Model\Property\Format\AbstractFormat;
use JsonSchemaPhpGenerator\Model\Property\Length;
use JsonSchemaPhpGenerator\Model\Property\LengthItems;
use JsonSchemaPhpGenerator\Model\Property\Range;

/**
 * Class ConditionalPropertyBag
 * @package JsonSchemaPhpGenerator\Model
 */
class ConditionalPropertyBag extends PropertyBag
{
    protected array $required = [];

    public function addString(
        string $name,
        string $description = '',
        ?AbstractFormat $format = null,
        ?Length $length = null,
        ?string $regex = null,
        bool $required = false
    ): ConditionalPropertyBag
    {
        parent::addString($name, $description, $format, $length, $regex);
        if ($required) {
            $this->addRequiredPropertyName($name);
        }
        return $this;
    }

    public function addNumber(
        string $name,
        string $description = '',
        ?Range $range = null,
        ?int $multipleOf = null,
        ?string $pattern = null,
        bool $required = false
    ): ConditionalPropertyBag
    {
        parent::addNumber($name, $description, $range, $multipleOf, $pattern);
        if ($required) {
            $this->addRequiredPropertyName($name);
        }
        return $this;
    }

    public function addInt(
        string $name,
        string $description = '',
        ?Range $range = null,
        ?int $multipleOf = null,
        ?string $pattern = null,
        bool $required = false
    ): ConditionalPropertyBag
    {
       parent::addInt($name, $description, $range, $multipleOf, $pattern);
        if ($required) {
            $this->addRequiredPropertyName($name);
        }
        return $this;
    }

    public function addBool(
        string $name,
        string $description = '',
        bool $required = false
    ): ConditionalPropertyBag
    {
        parent::addBool($name, $description);
        if ($required) {
            $this->addRequiredPropertyName($name);
        }
        return $this;
    }

    public function addNull(
        string $name,
        string $description = '',
        bool $required = false
    ): ConditionalPropertyBag
    {
        parent::addNull($name, $description);
        if ($required) {
            $this->addRequiredPropertyName($name);
        }
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
        bool $required = false
    ): ConditionalPropertyBag
    {
        parent::addArray($name, $itemBag, $description, $lengthItems, $default, $uniqueItems, $additionalItems);
        if ($required) {
            $this->addRequiredPropertyName($name);
        }
        return $this;
    }

    public function addReference(
        string $name,
        string $identifier,
        string $description = '',
        bool $required = false
    ): ConditionalPropertyBag
    {
        parent::addReference($name, $identifier, $description);
        if ($required) {
            $this->addRequiredPropertyName($name);
        }
        return $this;
    }

    public function addEnum(
        string $name,
        array $items,
        string $default = '',
        string $description = '',
        bool $required = false
    ): ConditionalPropertyBag
    {
        parent::addEnum($name, $items, $default, $description);
        if ($required) {
            $this->addRequiredPropertyName($name);
        }
        return $this;
    }

    public function addMultipleType(
        string $name,
        PropertyBag $propertyBag,
        string $description = '',
        bool $required = false
    ): ConditionalPropertyBag
    {
        parent::addMultipleType($name, $propertyBag, $description);
        if ($required) {
            $this->addRequiredPropertyName($name);
        }
        return $this;
    }

    public function addConst(
        string $name,
        string|bool|int|float $value,
        string $description = '',
        bool $required = false
    ): ConditionalPropertyBag
    {
        parent::addConst($name, $value, $description);
        if ($required) {
            $this->addRequiredPropertyName($name);
        }
        return $this;
    }
    /**
     * @param string $required
     * @return ConditionalPropertyBag
     */
    public function addRequiredPropertyName(string $required): ConditionalPropertyBag
    {
        $this->required[] = $required;
        return $this;
    }

    public function toArray(): array
    {
        $output = [];
        foreach ($this->items as $item) {
            $output["properties"][$item->getName()] = $item->toArray();
        }
        if (count($this->required) > 0) {
            $output['required'] = array_values(array_unique($this->required));
        }
        return $output;
    }
}
