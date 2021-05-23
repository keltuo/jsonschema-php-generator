<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Model\Property\Format;

/**
 * Class IdnEmail
 * @package JsonSchemaPhpGenerator\Model\Property\Format
 *
 * Built-in formats
 * @group Email addresses
 *
 * New in draft 7 The internationalized form of an Internet email address, see RFC 6531
 */
class IdnEmail extends AbstractFormat
{

    public function getType(): string
    {
        return 'idn-email';
    }
}
