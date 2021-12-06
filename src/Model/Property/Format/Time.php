<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Model\Property\Format;

/**
 * Class Time
 *
 * @package JsonSchemaPhpGenerator\Model\Property\Format
 *
 * Built-in formats
 * @group Dates and times
 *
 * New in draft 7 Time, for example, 20:20:39+00:00.
 */
class Time extends AbstractFormat
{
    public function getType(): string
    {
        return 'time';
    }
}
