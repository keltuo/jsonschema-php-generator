<?php declare(strict_types=1);

namespace JsonSchemaPhpGenerator;

/**
 * Interface ErrorWrapperInterface
 *
 * @package JsonSchemaPhpGenerator
 */
interface ErrorWrapperInterface
{
    public function getErrors(): array;

    public function setErrors(array $errors): ErrorWrapperInterface;

    public function createError(array $data = []): object;

    public function toArray(): array;
}
