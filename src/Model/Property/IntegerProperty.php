<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Model\Property;

/**
 * Class IntegerProperty
 *
 * @package JsonSchemaPhpGenerator\Model\Property
 * The integer type is used for integral numbers.
 */
class IntegerProperty extends NumberProperty
{
    public function getType(): string
    {
        return 'integer';
    }
}
