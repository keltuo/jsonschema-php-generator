<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Model\Property\Format;

/**
 * Class DateTime
 * @package JsonSchemaPhpGenerator\Model\Property\Format
 *
 * Built-in formats
 * @group Dates and times
 *
 * Date and time together, for example, 2018-11-13T20:20:39+00:00.
 */
class DateTime extends AbstractFormat
{

    public function getType(): string
    {
        return 'date-time';
    }
}
