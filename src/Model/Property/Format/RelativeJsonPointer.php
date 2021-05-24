<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Model\Property\Format;

/**
 * Class RelativeJsonPointer
 * @package JsonSchemaPhpGenerator\Model\Property\Format
 *
 * Built-in formats
 * @group JSON Pointer
 *
 * New in draft 7 A relative JSON pointer. https://datatracker.ietf.org/doc/html/draft-handrews-relative-json-pointer-01
 */
class RelativeJsonPointer extends AbstractFormat
{

    public function getType(): string
    {
        return 'relative-json-pointer';
    }
}
