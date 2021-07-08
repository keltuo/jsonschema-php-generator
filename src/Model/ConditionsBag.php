<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Model;

/**
 * Class ConditionsBag
 * @package JsonSchemaPhpGenerator\Model
 */
class ConditionsBag extends AbstractBag
{
    public function add(ConditionalPropertyBag $conditionalPropertyBag): ConditionsBag
    {
        if (!$conditionalPropertyBag->isEmpty()) {
            $items = $this->items;
            $items[] = $conditionalPropertyBag;
            $this->items = array_unique($items, SORT_REGULAR);
        }
        return $this;
    }

    protected function insertEntry(ModelInterface $entry): bool
    {
        return false;
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
