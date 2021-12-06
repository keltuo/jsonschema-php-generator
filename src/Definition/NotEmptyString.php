<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Definition;

use JsonSchemaPhpGenerator\AbstractDefinition;

/**
 * Class NotEmptyString
 *
 * @package App\JsonSchema\Definitions
 */
class NotEmptyString extends AbstractDefinition
{
    public const TYPE = self::TYPE_STRING;

    protected ?int $minLength = 1;
}
