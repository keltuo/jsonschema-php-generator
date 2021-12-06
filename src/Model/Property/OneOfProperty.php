<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Model\Property;

/**
 * Class OneOfProperty
 *
 * @package JsonSchemaPhpGenerator\Model\Property
 */
class OneOfProperty extends AnyOfProperty
{
    public function getType(): string
    {
        return 'oneOf';
    }
}
