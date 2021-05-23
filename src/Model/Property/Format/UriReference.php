<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Model\Property\Format;

/**
 * Class UriReference
 * @package JsonSchemaPhpGenerator\Model\Property\Format
 *
 * Built-in formats
 * @group Resource identifiers
 *
 * New in draft 6 A URI Reference (either a URI or a relative-reference), according to RFC3986
 */
class UriReference extends AbstractFormat
{

    public function getType(): string
    {
        return 'uri-reference';
    }
}
