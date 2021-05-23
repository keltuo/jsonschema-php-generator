<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Model\Property;

use JetBrains\PhpStorm\Pure;
use JsonSchemaPhpGenerator\AbstractDefinition;

/**
 * Class ReferenceProperty
 * @package JsonSchemaPhpGenerator\Model\Property
 *
 */
class ReferenceProperty extends AbstractProperty
{
    public function __construct(
        string $name,
        string $description = '',
        protected string $identifier = '',
    )
    {
        parent::__construct($name, $description);

    }
    public function getType(): string
    {
        return 'ref';
    }

    public function __toString(): string
    {
        return (string)json_encode($this);
    }


    public function toArray(): array
    {
        return [
            '$ref' => $this->identifier
        ];
    }

    #[Pure]
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
