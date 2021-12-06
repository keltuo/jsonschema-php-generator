<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Model\Property\Format;

/**
 * Class Date
 *
 * @package JsonSchemaPhpGenerator\Model\Property\Format
 *
 * Built-in formats
 * @group Dates and times
 *
 * New in draft 7 Date, for example, 2018-11-13.
 */
class Date extends AbstractFormat
{
    public function getType(): string
    {
        return 'date';
    }
}
