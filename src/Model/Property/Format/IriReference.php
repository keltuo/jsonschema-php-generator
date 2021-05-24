<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Model\Property\Format;

/**
 * Class IriReference
 * @package JsonSchemaPhpGenerator\Model\Property\Format
 *
 * Built-in formats
 * @group Resource identifiers
 *
 * New in draft 7 The internationalized equivalent of a “uri-reference”, according to RFC3987
 */
class IriReference extends AbstractFormat
{

    public function getType(): string
    {
        return 'iri-reference';
    }
}
