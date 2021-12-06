<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Schema;

use JsonSchemaPhpGenerator\AbstractSchema;
use JsonSchemaPhpGenerator\Definition\Example as Definition;

/**
 * Class Example
 *
 * @package JsonSchemaPhpGenerator\Schema
 */
class Example extends AbstractSchema
{
    protected string $schemaTitle = 'Example schema';

    /**
     * @throws \ReflectionException
     */
    protected function loadSchema(): void
    {
        $this->createSchemaFromDefinition(Definition::class);
    }
}
