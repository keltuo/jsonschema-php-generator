<?php declare(strict_types=1);

namespace JsonSchemaPhpGenerator;

/**
 * Interface GeneratorInterface
 * @package JsonSchemaPhpGenerator
 */
interface GeneratorInterface
{
    const TYPE_OBJECT = "object";
    const TYPE_STRING = "string";
    const TYPE_NUMBER = "number";
    const TYPE_NULL = "null";
    const TYPE_ARRAY = "array";
    const TYPE_BOOLEAN = "boolean";
}
