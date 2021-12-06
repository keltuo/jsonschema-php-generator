<?php declare(strict_types=1);

namespace JsonSchemaPhpGenerator;

/**
 * Interface GeneratorInterface
 *
 * @package JsonSchemaPhpGenerator
 */
interface GeneratorInterface
{
    public const TYPE_OBJECT = "object";
    public const TYPE_STRING = "string";
    public const TYPE_NUMBER = "number";
    public const TYPE_NULL = "null";
    public const TYPE_ARRAY = "array";
    public const TYPE_BOOLEAN = "boolean";
}
