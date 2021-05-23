<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Definition;

use \JsonSchemaPhpGenerator\AbstractDefinition;
use JsonSchemaPhpGenerator\Model\Property\Format\Date;

/**
 * Class ExampleMergeOldNewDefinitionProperties
 * @package JsonSchemaPhpGenerator\Definition
 */
class ExampleMergeOldNewDefinitionProperties extends AbstractDefinition
{
    const TYPE = self::TYPE_OBJECT;
    /** @var bool */
    protected bool $additionalProperties = false;

    protected function loadProperties(): void
    {
        // Example1: new definition properties
        $this->getPropertyBag()
            ->addString('password')
            ->addString('date-of-birth', '', new Date());

        // Example2: old definition properties
        $this->properties = '
        {
            "username": {
                "type": "string"
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
