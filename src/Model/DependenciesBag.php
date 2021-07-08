<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Model;

/**
 * Class DependenciesBag
 * @package JsonSchemaPhpGenerator\Model
 */
class DependenciesBag extends AbstractBag
{
    public function add(string $propertyName, string $dependencyPropertyName): DependenciesBag
    {
        $this->items[$propertyName][] = $dependencyPropertyName;
        $this->idMap[$propertyName][] = $dependencyPropertyName;
        return $this;
    }

    public function addConditionalProperty(
        string $propertyName,
        ConditionalPropertyBag $conditionalPropertyBag
    ): DependenciesBag
    {
        if (!$conditionalPropertyBag->isEmpty() && !$this->checkEntry($propertyName)) {
            $this->items[$propertyName] = $conditionalPropertyBag;
            $this->idMap[$propertyName] = $conditionalPropertyBag;
        }
        return $this;
    }

    public function toArray(): array
    {
        $output = [];
        foreach ($this->items as $key => $item) {
            if (is_array($item)) {
                $output[$key] = $item;
            } else {
                $output[$key] = $item->toArray();
            }
        }
        return $output;
    }
}
