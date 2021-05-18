<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Definition;

use \JsonSchemaPhpGenerator\AbstractDefinition;

/**
 * Class ExampleEnumValues
 * @package JsonSchemaPhpGenerator\Definition
 */
class ExampleEnumValues extends AbstractDefinition
{
    const TYPE = self::TYPE_STRING;
    /** @var bool */
    protected bool $additionalProperties = false;

    protected array $enumValues = [
        'ONE',
        'TWO'
    ];
}
