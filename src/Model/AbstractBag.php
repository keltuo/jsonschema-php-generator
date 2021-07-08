<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Model;

use JetBrains\PhpStorm\Pure;

/**
 * Class AbstractBag
 * @package JsonSchemaPhpGenerator
 */
abstract class AbstractBag implements \JsonSerializable, \Stringable
{
    protected array $items = [];
    protected array $idMap = [];

    public function get(int $index)
    {
        return $this->items[$index];
    }

    public function getItems(): array
    {
        return $this->items;
    }

    protected function insertEntry(ModelInterface $entry): bool
    {
        // Allow only unique values
        if ($this->checkEntry($entry->getIdentifier())) {
            return false;
        }

        $this->items[] = $entry;
        $this->idMap[$entry->getIdentifier()] = $entry;

        return true;
    }

    protected function checkEntry(string $property): bool
    {
        // Allow only unique values
        if (isset($this->idMap[$property])) {
            return true;
        }
        return false;
    }

    public function isEmpty(): bool
    {
        return empty($this->items);
    }

    public function __toString(): string
    {
        return (string)json_encode($this);
    }

    public function toArray(): array
    {
        return $this->items;
    }

    #[Pure]
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
