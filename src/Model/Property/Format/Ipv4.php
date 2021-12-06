<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Model\Property\Format;

/**
 * Class Ipv4
 *
 * @package JsonSchemaPhpGenerator\Model\Property\Format
 *
 * Built-in formats
 * @group IP Addresses
 *
 * IPv4 address, according to dotted-quad ABNF syntax as defined in RFC 2673,
 */
class Ipv4 extends AbstractFormat
{
    public function getType(): string
    {
        return 'ipv4';
    }
}
