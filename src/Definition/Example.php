<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Definition;

use \JsonSchemaPhpGenerator\AbstractDefinition;

/**
 * Class Example
 * @package JsonSchemaPhpGenerator\Definition
 */
class Example extends AbstractDefinition
{
    const TYPE = self::TYPE_OBJECT;
    /** @var bool */
    protected bool $additionalProperties = false;

    protected function loadProperties(): void
    {
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
