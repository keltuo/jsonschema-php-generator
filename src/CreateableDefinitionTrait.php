<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator;

use ReflectionClass;
use ReflectionException;
use RuntimeException;

/**
 * Class CreateableDefinitionTrait
 * @package JsonSchemaPhpGenerator
 */
trait CreateableDefinitionTrait
{

    /**
     * @param string $definitionClassString
     * @param object|null $object
     * @return string
     * @throws ReflectionException
     */
    public function findDefinition(string $definitionClassString = '', ?object &$object = null): string
    {
        $object = is_null($object) ? $this->createClassFromString($definitionClassString) : $object;
        if (
            is_a($object, AbstractDefinition::class)
            && method_exists($this, 'addDefinitions')
        ) {
            $this->addDefinitions($object->getDefinition());
        }

        return (new ReflectionClass($object))->getShortName();
    }

    public function findDefinitionAsRef(string $definitionClassString = '', ?object &$object = null): string
    {
        return $this->getDefinitionRefTag($this->findDefinition($definitionClassString, $object));
    }

    public function getDefinitionRefTag(string $definition): string
    {
        return '#/definitions/'.$definition;
    }

    /**
     * @param string $classString
     * @param array $args
     * @return object
     * @throws ReflectionException|RuntimeException
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
