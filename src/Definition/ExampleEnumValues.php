<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Definition;

use JsonSchemaPhpGenerator\AbstractDefinition;

/**
 * Class ExampleEnumValues
 *
 * @package JsonSchemaPhpGenerator\Definition
 */
class ExampleEnumValues extends AbstractDefinition
{
    public const TYPE = self::TYPE_STRING;

    protected bool $additionalProperties = false;

    protected array $enumValues = [
        'ONE',
        'TWO',
    ];
}
