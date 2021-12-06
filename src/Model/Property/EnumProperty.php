<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Model\Property;

use JetBrains\PhpStorm\Pure;

/**
 * Class EnumProperty
 *
 * @package JsonSchemaPhpGenerator\Model\Property
 */
class EnumProperty extends AbstractProperty
{
    #[Pure]
    public function __construct(
        string $name,
        protected array $items,
        protected string $default = '',
        string $description = '',
    )
    {
       parent::__construct($name, $description);
    }

    public function getType(): string
    {
        return 'enum';
    }

    public function toArray(): array
    {
        return \array_filter(
            [
                'type' => 'string',
                $this->getType() => $this->items,
                'description' => $this->description,
                'default' => $this->default,
            ],
            static fn ($item) => !empty($item)
        );
    }
}
