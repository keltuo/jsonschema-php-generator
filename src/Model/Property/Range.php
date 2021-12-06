<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Model\Property;

use JetBrains\PhpStorm\Pure;

/**
 * Class Range
 *
 * @package JsonSchemaPhpGenerator\Model\Property
 *
 * Ranges of numbers are specified using a combination of the minimum and maximum keywords,
 * (or exclusiveMinimum and exclusiveMaximum for expressing exclusive range).
 */
class Range implements \JsonSerializable, \Stringable
{
    /**
     * Range constructor.
     *
     * x ≥ $minOrEqualTo | minimum
     * x > $higherThenMin | exclusiveMinimum
     * x ≤ $maxOrEqualTo | maximum
     * x < $lowerThenMax | exclusiveMaximum
     */
    public function __construct(
        protected ?int $minOrEqualTo,
        protected ?int $maxOrEqualTo,
        protected ?int $higherThenMin,
        protected ?int $lowerThenMax,

    ) {}

    public function getMinOrEqualTo(): ?int
    {
        return $this->minOrEqualTo;
    }

    public function getMaxOrEqualTo(): ?int
    {
        return $this->maxOrEqualTo;
    }

    public function getHigherThenMin(): ?int
    {
        return $this->higherThenMin;
    }

    public function getLowerThenMax(): ?int
    {
        return $this->lowerThenMax;
    }

    public function toArray(): array
    {
        return \array_filter(
            [
                'minimum' => $this->getMinOrEqualTo(),
                'maximum' => $this->getMaxOrEqualTo(),
                'exclusiveMinimum' => $this->getHigherThenMin(),
                'exclusiveMaximum' => $this->getLowerThenMax(),
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
