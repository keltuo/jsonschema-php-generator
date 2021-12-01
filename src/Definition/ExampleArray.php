<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Definition;

use \JsonSchemaPhpGenerator\AbstractDefinition;
use JsonSchemaPhpGenerator\Model\Property\ArrayReferenceProperty;
use JsonSchemaPhpGenerator\Model\Property\ReferenceProperty;

/**
 * Class ExampleArray
 * @package JsonSchemaPhpGenerator\Definition
 */
class ExampleArray extends AbstractDefinition
{
    const TYPE = self::TYPE_ARRAY;
    /** @var bool */
    protected bool $additionalProperties = false;

    protected function loadProperties(): void
    {
        $this->getItemBag()
            ->add(
                new ReferenceProperty(
                    'example',
                    '',
                    $this->findDefinitionAsRef(Example::class)
                )
            );
    }
}
