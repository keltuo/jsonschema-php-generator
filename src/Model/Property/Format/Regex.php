<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Model\Property\Format;

/**
 * Class Regex
 * @package JsonSchemaPhpGenerator\Model\Property\Format
 *
 * Built-in formats
 * @group Regular Expressions
 *
 * New in draft 7 A regular expression, which should be valid according to the ECMA 262 dialect.
 */
class Regex extends AbstractFormat
{

    public function getType(): string
    {
        return 'regex';
    }
}
