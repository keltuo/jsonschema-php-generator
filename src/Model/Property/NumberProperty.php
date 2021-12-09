<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Model\Property;

use JetBrains\PhpStorm\Pure;

/**
 * Class NumberProperty
 *
 * @package JsonSchemaPhpGenerator\Model\Property
 * The number type is used for any numeric type, either integers or floating point numbers.
 */
class NumberProperty extends AbstractProperty
{
    #[Pure]
    public function __construct(
        string $name = '',
        string $description = '',
        protected ?Range $range = null,
        protected ?int $multipleOf = null,
        protected ?string $pattern = null,
    ) {
        parent::__construct($name, $description);
    }

    public function getType(): string
    {
        return 'number';
    }

    public function toArray(): array
    {
        $data = \array_filter(
            [
                'type' => $this->getType(),
                'description' => $this->description,
                'pattern' => $this->pattern,
            ],
            static fn ($item) => !empty($item)
        );

        if (!\is_null($this->range)) {
            $data = \array_merge($data, $this->range->toArray());
        }

        if (!\is_null($this->multipleOf)) {
            $data = \array_merge($data, ['multipleOf' => $this->multipleOf]);
        }

        return $data;
    }
}
