<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator;

use JsonException;
use JsonSchema\Validator;
use ReflectionException;
use stdClass;

/**
 * Class Schema
 *
 * @package JsonSchemaPhpGenerator
 */
abstract class AbstractSchema implements GeneratorInterface
{
    use CreateableDefinitionTrait;

    protected ErrorWrapperInterface $errorWrapper;

    protected string $schemaTitle = '';

    protected string $schema = '';

    /** @var array<string> */
    protected array $parameters = [];

    /** @var array<string> */
    protected array $definitions = [];

    /**
     * Schema constructor.
     */
    public function __construct()
    {
        $this->loadSchema();
        $this->errorWrapper = new ErrorWrapper();
    }

    public function getSchema(): string
    {
        return $this->schema;
    }

    /**
     * @param array<string|number|bool> $errors
     */
    public function validate(stdClass|array $data, array &$errors = []): bool
    {
        $validator = new Validator();

        try {
            $validator->validate($data, $this->decode());
            $validateErrors = $validator->getErrors();
        } catch (JsonException $exception) {
            $validateErrors[] = [
                'message' => $exception->getMessage(),
                'constraint' => [
                    'name' => 'internal_error',
                    'params' => [
                        'property' => \basename($exception->getFile()),
                    ],
                ],
                'context' => $exception->getLine(),
                'pointer' => 'internal_error',
                'property' => 'schema',
            ];
        }

        $errors = \array_unique(\array_merge(
            $errors,
            $this->errorWrapper->setErrors($validateErrors)->toArray()
        ), \SORT_REGULAR);

        return $validator->isValid();
    }

    /**
     * @throws JsonException
     */
    public function decode(): stdClass
    {
        return (object)\json_decode($this->getSchema(), false, 512, \JSON_THROW_ON_ERROR);
    }

    /**
     * @throws ReflectionException
     */
    public function createSchemaFromDefinition(string $definition): void
    {
        $renderDefinition = $this->findDefinition($definition);
        $this->addParameters('"$schema": "http://json-schema.org/draft-07/schema#"');
        $this->addParameters('"$ref": "#/definitions/'.$renderDefinition.'"');
        $this->addParameters('"title": "'.$this->schemaTitle.'"');

        if (\count($this->definitions) > 0) {
            $this->addParameters(
                '
            "definitions": {
                '. \implode(', ', $this->definitions).'
            }
          '
            );
        }

        $this->schema = '
        {
          '. \implode(', ', $this->parameters).'
        }
      ';
    }

    public function setErrorWrapper(ErrorWrapperInterface $errorWrapper): void
    {
        $this->errorWrapper = $errorWrapper;
    }

    protected function loadSchema(): void
    {
        /**
         * Empty for override
         */
    }

    protected function addParameters(string $parameters): void
    {
        if (!empty($parameters)) {
            $this->parameters[] = $parameters;
        }
    }

    protected function addDefinitions(string $definitions): void
    {
        if (!empty($definitions)) {
            $this->definitions[] = $definitions;
        }
    }
}
