<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Model\Property;

use JetBrains\PhpStorm\ArrayShape;

/**
 * Class LengthItems
 *
 * @package JsonSchemaPhpGenerator\Model\Property
 */
class LengthItems extends Length implements \JsonSerializable, \Stringable
{
    #[ArrayShape(['minItems' => "int|null", 'maxItems' => "int|null"])]
    public function toArray(): array
    {
        return \array_filter(
            [
                'minItems' => $this->getMin(),
                'maxItems' => $this->getMax(),
            ],
            static fn ($item) => !\is_null($item)
        );
    }
}
