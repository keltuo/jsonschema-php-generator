<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Schema;

use \JsonSchemaPhpGenerator\AbstractSchema;

/**
 * Class Example
 * @package JsonSchemaPhpGenerator\Schema
 */
class Example extends AbstractSchema
{
    /** @var string */
    public string $schemaTitle = 'Example schema';

    protected function loadSchema(): void
    {
        $this->createSchemaFromDefinition(\JsonSchemaPhpGenerator\Definition\Example::class);
    }
}
