<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Model\Property;


use JetBrains\PhpStorm\Pure;
use JsonSchemaPhpGenerator\Model\ItemBag;

/**
 * Class ArrayProperty
 * @package JsonSchemaPhpGenerator\Model\Property
 * Arrays are used for ordered elements. In JSON, each element in an array may be of a different type.
 */
class ArrayProperty extends AbstractProperty
{
    protected ItemBag $itemBag;
    #[Pure]
    public function __construct(
        string $name,
        string $description = '',
        protected ?LengthItems $lengthItems = null,
        protected string $default = '',
        protected ?bool $uniqueItems = null,
        protected ?bool $additionalItems = null,
    )
    {
        $this->itemBag = new ItemBag();
        parent::__construct($name, $description);
    }

    public function getType(): string
    {
        return 'array';
    }

    public function getItemBag(): ItemBag
    {
        return $this->itemBag;
    }

    public function setItemBag(ItemBag $itemBag): ArrayProperty
    {
        $this->itemBag = $itemBag;
        return $this;
    }

    public function addItemToBag(AbstractProperty $property): ArrayProperty
    {
        $this->getItemBag()->add($property);
        return $this;
    }

    public function toArray(): array
    {
        $data = array_filter(
            [
                'type' => $this->getType(),
                'description' => $this->description,
                'default' => $this->default,
            ],
            fn($item) => !empty($item)
        );

        if (!$this->getItemBag()->isEmpty()) {
            $data = array_merge($data, ['items' => $this->getItemBag()->toArray()]);
        }
        if(!is_null($this->lengthItems)) {
            $data = array_merge($data, $this->lengthItems->toArray());
        }
        if (!is_null($this->uniqueItems)) {
            $data = array_merge($data, ['uniqueItems' => $this->uniqueItems]);
        }
        if (!is_null($this->additionalItems)) {
            $data = array_merge($data, ['additionalItems' => $this->additionalItems]);
        }
        return $data;
    }
}
