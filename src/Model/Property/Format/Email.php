<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Model\Property\Format;

/**
 * Class Email
 * @package JsonSchemaPhpGenerator\Model\Property\Format
 *
 * Built-in formats
 * @group Email addresses
 *
 * Internet email address, see RFC 5322
 */
class Email extends AbstractFormat
{

    public function getType(): string
    {
        return 'email';
    }
}
