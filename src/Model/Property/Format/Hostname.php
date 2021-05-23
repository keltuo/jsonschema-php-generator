<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Model\Property\Format;

/**
 * Class Hostname
 * @package JsonSchemaPhpGenerator\Model\Property\Format
 *
 * Built-in formats
 * @group Hostnames
 *
 * Internet host name, see RFC 1034
 */
class Hostname extends AbstractFormat
{

    public function getType(): string
    {
        return 'hostname';
    }
}
