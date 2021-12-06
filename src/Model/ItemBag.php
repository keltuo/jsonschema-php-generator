<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Model;

use JsonSchemaPhpGenerator\Model\Property\AbstractProperty;

/**
 * Class ItemBag
 *
 * @package JsonSchemaPhpGenerator\Model
 */
class ItemBag extends AbstractBag
{
    public function add(AbstractProperty $property): ItemBag
    {
        if (empty($property->name)) {
            $property->name = (string)(\count($this->items)+1);
        }

        $this->insertEntry($property);
        return $this;
    }

    public function toArray(): array
    {
        $output = [];

        foreach ($this->items as $item) {
            $output[] = $item->toArray();
        }

        return $output;
    }
}
