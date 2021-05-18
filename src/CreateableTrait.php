<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator;

use ReflectionClass;
use ReflectionException;
use RuntimeException;

/**
 * Class CreateableTrait
 * @package JsonSchemaPhpGenerator
 */
trait CreateableTrait
{

    /**
     * @param string $definitionClassString
     * @param object|null $object
     * @return string
     * @throws ReflectionException
     */
    public function findDefinition(string $definitionClassString = '', ?object &$object = null): string
    {
        $object = $this->createClassFromString($definitionClassString);
        if (
            is_a($object, AbstractDefinition::class)
            && method_exists($this, 'addDefinitions')
        ) {
            $this->addDefinitions($object->getDefinition());
        }

        return (new ReflectionClass($object))->getShortName();
    }

    /**
     * @param string $classString
     * @param array $args
     * @return object
     * @throws ReflectionException
     */
    protected function createClassFromString(string $classString = '', array $args = []): object
    {
        if (empty($classString) || !class_exists($classString)) {
            throw new RuntimeException(sprintf('Excepted class %s was not found', $classString));
        }
        $classRef = new ReflectionClass($classString);
        return $classRef->newInstanceArgs($args);
    }
}
