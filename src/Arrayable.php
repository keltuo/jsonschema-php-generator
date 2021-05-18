<?php declare(strict_types=1);

namespace JsonSchemaPhpGenerator;

/**
 * Interface Arrayable
 * @package JsonSchemaPhpGenerator
 */
interface Arrayable
{
    /**
     * @return array<string,int>
     */
    public function toArray(): array;
}
