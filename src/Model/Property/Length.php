<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Model\Property;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

/**
 * Class Length
 *
 * @package JsonSchemaPhpGenerator\Model\Property
 */
class Length implements \JsonSerializable, \Stringable
{
    public function __construct(
        protected ?int $min,
        protected ?int $max,
    ) {
    }

    public function getMin(): ?int
    {
        return $this->min;
    }

    public function getMax(): ?int
    {
        return $this->max;
    }

    #[ArrayShape(['minLength' => "int|null", 'maxLength' => "int|null"])]
    public function toArray(): array
    {
        return \array_filter(
            [
                'minLength' => $this->getMin(),
                'maxLength' => $this->getMax(),
            ],
            static fn ($item) => !\is_null($item)
        );
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
