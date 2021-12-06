<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Model\Property;

use JetBrains\PhpStorm\Pure;
use JsonSchemaPhpGenerator\Model\Property\Format\AbstractFormat;

/**
 * Class StringProperty
 *
 * @package JsonSchemaPhpGenerator\Model\Property
 */
class StringProperty extends AbstractProperty
{
    #[Pure]
    public function __construct(
        string $name,
        string $description = '',
        protected ?AbstractFormat $format = null,
        protected ?Length $length = null,
        protected ?string $regex = null,
    )
    {
       parent::__construct($name, $description);
    }

    public function getType(): string
    {
        return 'string';
    }

    public function toArray(): array
    {
        $data = \array_filter(
            [
                'type' => $this->getType(),
                'description' => $this->description,
                'pattern' => $this->regex,
            ],
            static fn ($item) => !empty($item)
        );

        if (!\is_null($this->length)) {
            $data = \array_merge($data, $this->length->toArray());
        }

        if (!\is_null($this->format)) {
            $data = \array_merge($data, $this->format->toArray());
        }

        return $data;
    }
}
