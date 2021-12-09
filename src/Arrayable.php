<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator;

/**
 * Interface Arrayable
 *
 * @package JsonSchemaPhpGenerator
 */
interface Arrayable
{
    public function toArray(): array;
}
