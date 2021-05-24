<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Definition;

use \JsonSchemaPhpGenerator\AbstractDefinition;
use JsonSchemaPhpGenerator\Model\Property\Format\Date;

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
        // Example1: new definition properties
        $this->getPropertyBag()
            ->addString('username')
            ->addString('password')
            ->addString('date-of-birth', '', new Date())
            ->addReference('note', $this->findDefinitionAsRef(NotEmptyString::class));

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
