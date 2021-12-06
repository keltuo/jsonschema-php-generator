<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Model\Property\Format;

/**
 * Class JsonPointer
 *
 * @package JsonSchemaPhpGenerator\Model\Property\Format
 *
 * Built-in formats
 * @group JSON Pointer
 *
 * New in draft 6 A JSON Pointer, according to RFC6901.
 * There is more discussion on the use of JSON Pointer within JSON Schema in Structuring a complex schema.
 * Note that this should be used only when the entire string contains only JSON Pointer content,
 * e.g. /foo/bar. JSON Pointer URI fragments, e.g. #/foo/bar/ should use "uri-reference".
 */
class JsonPointer extends AbstractFormat
{
    public function getType(): string
    {
        return 'json-pointer';
    }
}
