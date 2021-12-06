<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Model\Property\Format;

/**
 * Class IdnHostname
 *
 * @package JsonSchemaPhpGenerator\Model\Property\Format
 *
 * Built-in formats
 * @group Hostnames
 *
 * New in draft 7 An internationalized Internet host name, see RFC5890
 */
class IdnHostname extends AbstractFormat
{
    public function getType(): string
    {
        return 'idn-hostname';
    }
}
