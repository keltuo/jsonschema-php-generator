<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator;

use ReflectionClass;
use function implode;

/**
 * Class Definition
 * @package JsonSchemaPhpGenerator
 */
abstract class AbstractDefinition implements GeneratorInterface
{
    use CreateableTrait;

    const TYPE = self::TYPE_OBJECT;
    /** @var bool */
    protected bool $additionalProperties = false;
    /** @var string */
    protected string $definition;
    /** @var string */
    protected string $properties;
    /** @var string */
    protected string $required;
    /** @var string */
    protected string $enum;
    /** @var string[] */
    protected array $additionalDefinitions = [];
    /** @var string[] */
    protected array $dependencies = [];
    /** @var string */
    protected string $oneOf;
    /** @var string  */
    protected string $anyOf;
    /** @var string  */
    protected string $allOf;
    /** @var int|null  */
    protected ?int $minLength = null;
    /** @var int|null  */
    protected ?int $maxLength = null;
    /** @var array<int, bool|number|string> */
    protected array $enumValues = [];

    /**
     * Definition constructor.
     */
    public function __construct()
    {
        $this->loadDefinition();
    }

    protected function loadProperties(): void
    {
    }

    protected function loadDependencies(): void
    {
    }

    protected function loadRequired(): void
    {
    }

    protected function loadEnum(): void
    {
        if (count($this->enumValues) > 0) {
            $this->enum = (string)json_encode($this->enumValues);
        }
    }

    /**
     * @param array<int, string> $exclude
     * @return array
     */
    public function getEnumValues(array $exclude = []): array
    {
        return array_filter($this->enumValues, fn ($value) => !in_array($value, $exclude));
    }

    protected function loadDefinition(): void
    {
        $this->loadProperties();
        $this->loadRequired();
        switch (static::TYPE) {
            case self::TYPE_OBJECT:
                $className = $this->getClassName();
                $definition = $this->generateDefinition();
                $this->addDefinitions(
                    '
                  "' . $className . '": {
                    ' . implode(",", $definition) . '
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

    /**
     * @return string
     */
    protected function hasAdditionalProperties(): string
    {
        return $this->additionalProperties ? 'true' : 'false';
    }

    /**
     * @return string
     */
    public function getDefinition(): string
    {
        return $this->definition;
    }

    /**
     * @param string $definition
     */
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
        $this->required = (string)json_encode($required);
    }

    /**
     * @param string $dependency
     */
    protected function addDependency(string $dependency): void
    {
        if (is_string($dependency) && !empty($dependency)) {
            $this->dependencies[] = $dependency;
        }
    }

    /**
     * @return string
     */
    public function getClassName(): string
    {
        return (new ReflectionClass($this))->getShortName();
    }

    /**
     * @param  string  $type
     * @param  bool  $additionalProperties
     * @return array<string>
     */
    protected function generateDefinition(string $type = self::TYPE_OBJECT, bool $additionalProperties = true): array
    {
        $className = $this->getClassName();
        $definition = [
            '"type": "' . $type . '"',
            '"title": "' . $className . '"',
        ];
        if (!is_null($this->minLength)) {
            $definition[] = '"minLength": '.$this->minLength;
        }
        if (!is_null($this->maxLength)) {
            $definition[] = '"maxLength": '.$this->maxLength;
        }
        if ($additionalProperties) {
            $definition[] = '"additionalProperties": ' . $this->hasAdditionalProperties() . '';
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
        if (count($this->dependencies) > 0) {
            $definition[] = '"dependency": ' . json_encode($this->dependencies) . '';
        }
        if (!empty($this->oneOf)) {
            $definition[] = '"oneOf": ' . $this->oneOf . '';
        }
        if (!empty($this->anyOf)) {
            $definition[] = '"anyOf": ' . $this->anyOf . '';
        }
        if (!empty($this->allOf)) {
            $definition[] = '"allOf": ' . $this->allOf . '';
        }

        return $definition;
    }

    /**
     * @param  array<string>  $definitions
     */
    protected function setDefinitions(array $definitions = []): void
    {
        $className = $this->getClassName();
        if (count($this->additionalDefinitions) > 0) {
            $this->definition = implode(", ", $this->additionalDefinitions);
        } else {
            $this->definition = '
              "' . $className . '": {
                 ' . implode(",", $definitions) . '
              }
            ';
        }
    }
}
