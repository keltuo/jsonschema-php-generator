<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Model\Property\Format;

/**
 * Class UriTemplate
 *
 * @package JsonSchemaPhpGenerator\Model\Property\Format
 *
 * Built-in formats
 * @group URI template
 *
 * New in draft 6 A URI Template (of any level) according to RFC6570.
 * If you don’t already know what a URI Template is,
 * you probably don’t need this value.
 */
class UriTemplate extends AbstractFormat
{
    public function getType(): string
    {
        return 'uri-template';
    }
}
