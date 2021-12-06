<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Model\Property\Format;

/**
 * Class Iri
 *
 * @package JsonSchemaPhpGenerator\Model\Property\Format
 *
 * Built-in formats
 * @group Resource identifiers
 *
 * New in draft 7 The internationalized equivalent of a “uri”, according to RFC3987
 */
class Iri extends AbstractFormat
{
    public function getType(): string
    {
        return 'iri';
    }
}
