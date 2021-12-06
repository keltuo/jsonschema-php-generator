<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Model\Property\Format;

/**
 * Class Ipv6
 *
 * @package JsonSchemaPhpGenerator\Model\Property\Format
 *
 * Built-in formats
 * @group IP Addresses
 *
 * IPv6 address, as defined in RFC 2373
 */
class Ipv6 extends AbstractFormat
{
    public function getType(): string
    {
        return 'ipv6';
    }
}
