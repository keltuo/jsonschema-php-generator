<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Definition;

use JsonSchemaPhpGenerator\AbstractDefinition;
use JsonSchemaPhpGenerator\Model\Property\Format\Date;

/**
 * Class Example
 *
 * @package JsonSchemaPhpGenerator\Definition
 */
class Example extends AbstractDefinition
{
    public const TYPE = self::TYPE_OBJECT;

    protected bool $additionalProperties = false;

    protected function loadProperties(): void
    {
        // Example1: new definition properties
        $this->getPropertyBag()
            ->addString('username')
            ->addString('password')
            ->addString('date-of-birth', '', new Date())
            ->addReference('note', $this->findDefinitionAsRef(NotEmptyString::class))
            ->addConst('state', 'United states')
            ->addConst('newsletter', true)
            ->addEnum('enum_values', ['red', 'amber', 'green', null, 42]);

        // Example2: old definition properties
        $this->properties = '
        {
            "username": {
                "type": "string"
            },
            "password": {
                "type": "string"
            },
            "date-of-birth": {
                "type": "string",
                "format": "date"
            },
            "note": {
                "$ref": "'.$this->findDefinitionAsRef(NotEmptyString::class).'"
            },
            "state": {
                "const": "United states"
            },
            "newsletter": {
                "const": true
            }
        }
        ';
    }

    protected function loadRequired(): void
    {
        $this->addRequired(
            [
                "username",
                "password",
            ]
        );
    }
}
