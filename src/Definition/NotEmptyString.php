<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Definition;

use JsonSchemaPhpGenerator\AbstractDefinition;

/**
 * Class NotEmptyString
 * @package App\JsonSchema\Definitions
 */
class NotEmptyString extends AbstractDefinition
{
    const TYPE = self::TYPE_STRING;
    /** @var int|null  */
    public ?int $minLength = 1;
}
