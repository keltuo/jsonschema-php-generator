<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Model\Property\Format;

/**
 * Class Uri
 *
 * @package JsonSchemaPhpGenerator\Model\Property\Format
 *
 * Built-in formats
 * @group Resource identifiers
 *
 * A universal resource identifier (URI), according to RFC3986
 */
class Uri extends AbstractFormat
{
    public function getType(): string
    {
        return 'uri';
    }
}
