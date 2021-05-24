<?php
declare(strict_types=1);

namespace JsonSchemaPhpGenerator;

use JsonException;
use JsonSchema\Validator;
use ReflectionException;
use stdClass;
use function implode;
use function json_decode;

/**
 * Class Schema
 * @package JsonSchemaPhpGenerator
 */
abstract class AbstractSchema implements GeneratorInterface
{
    use CreateableDefinitionTrait;

    /** @var ErrorWrapperInterface  */
    protected ErrorWrapperInterface $errorWrapper;
    /** @var string */
    protected string $schemaTitle = '';
    /** @var string */
    protected string $schema = '';
    /** @var string[] */
    protected array $parameters = [];
    /** @var string[] */
    protected array $definitions = [];

    /**
     * Schema constructor.
     */
    public function __construct()
    {
        $this->loadSchema();
        $this->errorWrapper = new ErrorWrapper();
    }

    /** @return void */
    protected function loadSchema()
    {
    }
    /**
     * @return string
     */
    public function getSchema(): string
    {
        return $this->schema;
    }

    /**
     * @param stdClass $data
     * @param  array<string|number|bool> $errors
     * @return bool
     */
    public function validate(stdClass $data, array &$errors = []): bool
    {
        $validator = new Validator();
        try {
            $validator->validate($data, $this->decode());
            $errors = $validator->getErrors();
        } catch (JsonException $exception) {
            $errors[] = [
                'message' => $exception->getMessage(),
                'constraint' => basename($exception->getFile()),
                'context' => $exception->getLine(),
                'pointer' => 'internal_error',
                'property' => 'schema',
            ];
        }
        $errors = $this->errorWrapper->setErrors($errors)->toArray();

        return $validator->isValid();
    }

    /**
     * @param string $parameters
     */
    protected function addParameters(string $parameters): void
    {
        if (is_string($parameters) && !empty($parameters)) {
            $this->parameters[] = $parameters;
        }
    }

    /**
     * @return stdClass
     * @throws JsonException
     */
    public function decode(): stdClass
    {
        return json_decode($this->getSchema(), false, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * @param string $definitions
     */
    protected function addDefinitions(string $definitions): void
    {
        if (is_string($definitions) && !empty($definitions)) {
            $this->definitions[] = $definitions;
        }
    }

    /**
     * @param string $definition
     * @throws ReflectionException
     */
    public function createSchemaFromDefinition(string $definition): void
    {
        $renderDefinition = $this->findDefinition($definition);
        $this->addParameters('"$schema": "http://json-schema.org/draft-07/schema#"');
        $this->addParameters('"$ref": "#/definitions/'.$renderDefinition.'"');
        $this->addParameters('"title": "'.$this->schemaTitle.'"');
        if (count($this->definitions) > 0) {
            $this->addParameters(
                '
            "definitions": {
                '. implode(', ', $this->definitions).'
            }
          '
            );
        }

        $this->schema = '
        {
          '. implode(', ', $this->parameters).'
        }
      ';
    }

    /**
     * @param ErrorWrapperInterface $errorWrapper
     */
    public function setErrorWrapper(ErrorWrapperInterface $errorWrapper): void
    {
        $this->errorWrapper = $errorWrapper;
    }

}
