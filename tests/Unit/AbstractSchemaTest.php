<?php declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Tests\Unit;

use JsonSchemaPhpGenerator\Definition\Example as ExampleDefinition;
use JsonSchemaPhpGenerator\Definition\ExampleMergeOldNewDefinitionProperties;
use PHPUnit\Framework\TestCase;

/**
 * Class AbstractSchemaTest
 * @package JsonSchemaPhpGenerator\Tests\Unit
 */
class AbstractSchemaTest extends TestCase
{
    public function testCanCreateSchemaFromDefinition()
    {
        $schema = $this->getMockForAbstractClass(
            '\JsonSchemaPhpGenerator\AbstractSchema',
        );
        $schema->createSchemaFromDefinition(ExampleDefinition::class);
        $this->assertEquals(json_decode('
        {
           "$schema":"http://json-schema.org/draft-07/schema#",
           "$ref":"#/definitions/Example",
           "title":"",
           "definitions":{
              "Example":{
                 "type":"object",
                 "title":"Example",
                 "additionalProperties":false,
                 "properties":{
                    "username":{
                       "type":"string"
                    },
                    "password":{
                       "type":"string"
                    },
                    "date-of-birth":{
                       "type":"string",
                       "format":"date"
                    },
                    "note": {
                        "$ref": "#/definitions/NotEmptyString"
                    }
                 },
                 "required":[
                    "username",
                    "password"
                 ]
              },
              "NotEmptyString": {
                "type": "string",
                "title": "NotEmptyString",
                "minLength": 1,
                "additionalProperties": false
              }
           }
        }
        '), $schema->decode());
    }

    public function testCanThrowExceptionDecode()
    {
        $this->expectException(\JsonException::class);
        $this->expectExceptionMessage('Syntax error');
        $schema = $this->getMockForAbstractClass(
            '\JsonSchemaPhpGenerator\AbstractSchema',
            [],
            '',
            true,
            true,
            true,
            [
                'getSchema'
            ]
        );
        $schema->method('getSchema')
            ->willReturn('{');
        $this->assertSame('{', $schema->getSchema());
        $schema->decode();
    }

    public function testValidateSchema()
    {
        $schema = $this->getMockForAbstractClass(
            '\JsonSchemaPhpGenerator\AbstractSchema',
            [],
            '',
            true,
            true,
            true,
            [
                'getSchema'
            ]
        );
        $schema->method('getSchema')
            ->willReturn('
            {
               "$schema":"http://json-schema.org/draft-07/schema#",
               "$ref":"#/definitions/Example",
               "title":"",
               "definitions":{
                "Example":{
                    "type":"object",
                     "title":"Example",
                     "additionalProperties":false,
                     "properties":{
                        "username":{
                            "type":"string"
                        },
                        "password":{
                            "type":"string"
                        },
                        "date-of-birth":{
                            "type":"string",
                           "format":"date"
                        }
                     },
                     "required":[
                        "username",
                        "password"
                    ]
                  }
               }
            }
            ');

        $errors = [];
        $this->assertTrue($schema->validate(json_decode(
            '{
                "username": "Lukas",
                "password": "Skywalker"
            }'
        ), $errors));
        $this->assertSame([], $errors);

        $this->assertFalse($schema->validate(json_decode(
        '{
                "username": "Lukas"
            }'
        ), $errors));
        $this->assertSame([
            [
            'property' => 'password',
            'pointer' => '/password',
            'message' => 'The property password is required',
            'constraint' => 'required',
            'context' => 1
            ]
        ], $errors);

        $this->assertFalse($schema->validate(json_decode(
        '{
                "password": "1234"
            }'
        ), $errors));
        $this->assertSame([
            0 => [
                'property' => 'password',
                'pointer' => '/password',
                'message' => 'The property password is required',
                'constraint' => 'required',
                'context' => 1
            ],
            2 => [
                'property' => 'username',
                'pointer' => '/username',
                'message' => 'The property username is required',
                'constraint' => 'required',
                'context' => 1
            ]
        ], $errors);
    }

    public function testCanNotValidateSchema()
    {
        $schema = $this->getMockForAbstractClass(
            '\JsonSchemaPhpGenerator\AbstractSchema',
            [],
            '',
            true,
            true,
            true,
            [
                'getSchema'
            ]
        );
        $schema->method('getSchema')
            ->willReturn('
            {
               "$schema":"http://json-schema.org/draft-07/schema#",
               "$ref":"#/definitions/Example",
               "title":"",
               "definitions":{
                "Example":{
                    "type":"object",
                     "title":"Example",
                     "additionalProperties":false,
                     "properties":{
                        "username":{
                            "type":"string"
                        },
                        "password":{
                            "type":"string"
                        },
                        "date-of-birth":{
                            "type":"string",
                           "format":"date"
                        }
                     },
                     "required":[
                        "username",
                        "password", // not valid json
                    ]
                  }
               }
            }
            ');
        $errors = [];
        $this->assertTrue($schema->validate(json_decode(
            '{
                "username": "Lukas",
                "password": "Skywalker"
            }'
        ), $errors));
        $this->assertSame([
            [
                'property' => 'schema',
                'pointer' => 'internal_error',
                'message' => 'Syntax error',
                'constraint' => 'AbstractSchema.php',
                'context' => 97
            ]
        ], $errors);
    }

    public function testCanMergeOldAndNewPropertyDefinitions()
    {
        $schema = $this->getMockForAbstractClass(
            '\JsonSchemaPhpGenerator\AbstractSchema',
        );
        $schema->createSchemaFromDefinition(ExampleMergeOldNewDefinitionProperties::class);
        $this->assertEquals(json_decode('
        {
           "$schema":"http://json-schema.org/draft-07/schema#",
           "$ref":"#/definitions/ExampleMergeOldNewDefinitionProperties",
           "title":"",
           "definitions":{
              "ExampleMergeOldNewDefinitionProperties":{
                 "type":"object",
                 "title":"ExampleMergeOldNewDefinitionProperties",
                 "additionalProperties":false,
                 "properties":{
                    "username":{
                       "type":"string"
                    },
                    "password":{
                       "type":"string"
                    },
                    "date-of-birth":{
                       "type":"string",
                       "format":"date"
                    },
                    "note": {
                        "$ref": "#/definitions/NotEmptyString"
                    }
                 },
                 "required":[
                    "username",
                    "password"
                 ]
              },
              "NotEmptyString": {
                "type": "string",
                "title": "NotEmptyString",
                "minLength": 1,
                "additionalProperties": false
              }
           }
        }
        '), $schema->decode());
    }

}
