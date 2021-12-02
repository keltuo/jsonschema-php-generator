<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Definition;

use \JsonSchemaPhpGenerator\AbstractDefinition;
use JsonSchemaPhpGenerator\Model\Property\ReferenceProperty;

/**
 * Class ExampleArrayItemsTypes
 * @package JsonSchemaPhpGenerator\Definition
 */
class ExampleArrayItemsTypes extends AbstractDefinition
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
            )
            ->add(
                new ReferenceProperty(
                    'example2',
                    '',
                    $this->findDefinitionAsRef(Example::class)
                )
            );
    }
}
