<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator;

use JsonSchemaPhpGenerator\Model\ConditionsBag;
use JsonSchemaPhpGenerator\Model\DependenciesBag;
use JsonSchemaPhpGenerator\Model\ItemBag;
use JsonSchemaPhpGenerator\Model\PropertyBag;
use ReflectionClass;

/**
 * Class Definition
 *
 * @package JsonSchemaPhpGenerator
 */
abstract class AbstractDefinition implements GeneratorInterface
{
    use CreateableDefinitionTrait;

    public const TYPE = self::TYPE_OBJECT;

    protected ?PropertyBag $propertyBag = null;

    protected bool $additionalProperties = false;

    protected string $definition = '';

    protected string $properties = '';

    protected string $required = '';

    protected string $enum = '';

    /** @var array<string> */
    protected array $additionalDefinitions = [];

    protected ?DependenciesBag $dependencies = null;

    protected ?ConditionsBag $oneOf = null;

    protected ?ConditionsBag $anyOf = null;

    protected ?ConditionsBag $allOf = null;

    protected ?int $minLength = null;

    protected ?int $maxLength = null;

    /** @var array<int, bool|number|string> */
    protected array $enumValues = [];

    protected ?ItemBag $itemBag = null;

    /**
     * Definition constructor.
     */
    public function __construct()
    {
        $this->loadDefinition();
    }

    public function getPropertyBag(): PropertyBag
    {
        if(\is_null($this->propertyBag)) {
            $this->propertyBag = new PropertyBag();
        }

        return $this->propertyBag;
    }

    public function getDependenciesBag(): DependenciesBag
    {
        if(\is_null($this->dependencies)) {
            $this->dependencies = new DependenciesBag();
        }

        return $this->dependencies;
    }

    public function getOneOfBag(): ConditionsBag
    {
        if(\is_null($this->oneOf)) {
            $this->oneOf = new ConditionsBag();
        }

        return $this->oneOf;
    }

    public function getAnyOfBag(): ConditionsBag
    {
        if(\is_null($this->anyOf)) {
            $this->anyOf = new ConditionsBag();
        }

        return $this->anyOf;
    }

    public function getAllOfBag(): ConditionsBag
    {
        if(\is_null($this->allOf)) {
            $this->allOf = new ConditionsBag();
        }

        return $this->allOf;
    }

    public function getItemBag(): ItemBag
    {
        if(\is_null($this->itemBag)) {
            $this->itemBag = new ItemBag();
        }

        return $this->itemBag;
    }

    /**
     * @param array<int, string> $exclude
     * @return array
     */
    public function getEnumValues(array $exclude = []): array
    {
        return \array_filter($this->enumValues, static fn ($value) => !\in_array($value, $exclude));
    }

    public function getDefinition(): string
    {
        return $this->definition;
    }

    public function getClassName(): string
    {
        return (new ReflectionClass($this))->getShortName();
    }

    protected function loadProperties(): void
    {
        /**
         * Empty for override
         */
    }

    protected function loadDependencies(): void
    {
        /**
         * Empty for override
         */
    }

    protected function loadRequired(): void
    {
        /**
         * Empty for override
         */
    }

    protected function loadEnum(): void
    {
        if (\count($this->enumValues) > 0) {
            $this->enum = (string)\json_encode($this->enumValues);
        }
    }

    protected function loadDefinition(): void
    {
        $this->loadProperties();
        $this->loadRequired();

        switch (static::TYPE) {
            case self::TYPE_OBJECT:
            case self::TYPE_ARRAY:
                $className = $this->getClassName();
                $definition = $this->generateDefinition(static::TYPE);
                $this->addDefinitions(
                    '
                  "' . $className . '": {
                    ' . \implode(",", $definition) . '
                  }
                '
                );
                $this->setDefinitions([]);
                break;

            default:
                $this->loadProperties();
                $this->loadRequired();
                $this->loadEnum();
                $this->loadDependencies();
                $this->setDefinitions($this->generateDefinition(static::TYPE));
                break;
        }
    }

    protected function hasAdditionalProperties(): string
    {
        return $this->additionalProperties ? 'true' : 'false';
    }

    protected function addDefinitions(string $definition): void
    {
        if (!empty($definition)) {
            $this->additionalDefinitions[] = (string)$definition;
        }
    }

    /**
     * @param array<string> $required
     */
    protected function addRequired(array $required): void
    {
        $this->required = (string)\json_encode($required);
    }

    /**
     * @return array<string>
     */
    protected function generateDefinition(string $type = self::TYPE_OBJECT, bool $additionalProperties = true): array
    {
        $className = $this->getClassName();
        $definition = [];
        $definition[] = '"type": "' . $type . '"';
        $definition[] = '"title": "' . $className . '"';

        if (!\is_null($this->minLength)) {
            $definition[] = '"minLength": '.$this->minLength;
        }

        if (!\is_null($this->maxLength)) {
            $definition[] = '"maxLength": '.$this->maxLength;
        }

        if ($additionalProperties) {
            $definition[] = '"additionalProperties": ' . $this->hasAdditionalProperties() . '';
        }

        if (!$this->getPropertyBag()->isEmpty()) {
            $properties = [];

            if (!empty($this->properties)) {
                $properties = (array)\json_decode($this->properties, true);
            }

            $this->properties = (string)\json_encode(
                \array_merge($properties, $this->getPropertyBag()->toArray())
            );
        }

        if (!empty($this->properties)) {
            $definition[] = '"properties": ' . $this->properties . '';
        }

        if (!empty($this->required)) {
            $definition[] = '"required": ' . $this->required . '';
        }

        if (!empty($this->enum)) {
            $definition[] = '"enum": ' . $this->enum . '';
        }

        if (!$this->getDependenciesBag()->isEmpty()) {
            $definition[] = '"dependencies": ' . (string)\json_encode($this->getDependenciesBag()->toArray()) . '';
        }

        if (!$this->getOneOfBag()->isEmpty()) {
            $definition[] = '"oneOf": ' . (string)\json_encode($this->getOneOfBag()->toArray()) . '';
        }

        if (!$this->getAnyOfBag()->isEmpty()) {
            $definition[] = '"anyOf": ' . (string)\json_encode($this->getAnyOfBag()->toArray()) . '';
        }

        if (!$this->getAllOfBag()->isEmpty()) {
            $definition[] = '"allOf": ' . (string)\json_encode($this->getAllOfBag()->toArray()) . '';
        }

        if (!$this->getItemBag()->isEmpty()) {
            $items = $this->getItemBag()->toArray();

            if(\count($items) === 1) {
                $items = \current($items);
            }

            $definition[] = '"items": ' . (string)\json_encode($items) . '';
        }

        return $definition;
    }

    /**
     * @param array<string> $definitions
     */
    protected function setDefinitions(array $definitions = []): void
    {
        $className = $this->getClassName();

        $this->definition = \count($this->additionalDefinitions) > 0 ? \implode(", ", $this->additionalDefinitions) : '
              "' . $className . '": {
                 ' . \implode(",", $definitions) . '
              }
            ';
    }
}
