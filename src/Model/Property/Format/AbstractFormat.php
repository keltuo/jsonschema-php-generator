<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Model\Property\Format;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

/**
 * Class AbstractFormat
 *
 * @package JsonSchemaPhpGenerator\Model\Property\Format
 */
abstract class AbstractFormat implements \JsonSerializable, \Stringable
{
    abstract public function getType(): string;

    #[ArrayShape(['format' => "string"])]
    public function toArray(): array
    {
        return [
            'format' => $this->getType(),
        ];
    }

    #[Pure]
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function __toString(): string
    {
        return (string)\json_encode($this);
    }
}
