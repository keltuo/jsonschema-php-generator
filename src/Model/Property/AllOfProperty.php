<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Model\Property;

/**
 * Class AllOfProperty
 *
 * @package JsonSchemaPhpGenerator\Model\Property
 */
class AllOfProperty extends AnyOfProperty
{
    public function getType(): string
    {
        return 'allOf';
    }
}
