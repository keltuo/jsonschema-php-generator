<?php declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Tests\Unit;

use JsonSchemaPhpGenerator\Definition\Example as ExampleDefinition;
use JsonSchemaPhpGenerator\Definition\ExampleArray;
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
                    },
                    "state": {
                        "const": "United states"
                    },
                    "newsletter": {
                        "const": true
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
                        },
                        "state": {
                            "const": "United states"
                        },
                        "newsletter": {
                            "const": true
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
            'constraint' => [
                'name' => 'required',
                'params' => [
                    'property' => 'password'
                ]
            ],
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
                'constraint' => [
                    'name' => 'required',
                    'params' => [
                        'property' => 'password'
                    ]
                ],
                'context' => 1
            ],
            2 => [
                'property' => 'username',
                'pointer' => '/username',
                'message' => 'The property username is required',
                'constraint' => [
                    'name' => 'required',
                    'params' => [
                        'property' => 'username'
                    ]
                ],
                'context' => 1
            ]
        ], $errors);

        $this->assertFalse($schema->validate(json_decode(
            '{
                "username": "Lukas",
                "password": "1234",
                "newsletter": false
            }'
        ), $errors));
        $this->assertSame([
            0 => [
                'property' => 'password',
                'pointer' => '/password',
                'message' => 'The property password is required',
                'constraint' => [
                    'name' => 'required',
                    'params' => [
                        'property' => 'password'
                    ]
                ],
                'context' => 1
            ],
            1 => [
                'property' => 'username',
                'pointer' => '/username',
                'message' => 'The property username is required',
                'constraint' => [
                    'name' => 'required',
                    'params' => [
                        'property' => 'username'
                    ]
                ],
                'context' => 1
            ],
            4 => [
                'property' => 'newsletter',
                'pointer' => '/newsletter',
                'message' => 'Does not have a value equal to true',
                'constraint' => [
                    'name' => 'const',
                    'params' => [
                        'const' => true
                    ]
                ],
                'context' => 1
            ],

        ],$errors);
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
                'constraint' =>  [
                    'name' => 'internal_error',
                    'params' => [
                        'property' => 'AbstractSchema.php'
                    ]
                ],
                'context' => 102
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

    public function testCanValidateSchemaAsArrayDefinitions()
    {
        $schema = $this->getMockForAbstractClass(
            '\JsonSchemaPhpGenerator\AbstractSchema',
        );
        $schema->createSchemaFromDefinition(ExampleArray::class);
        $this->assertEquals(json_decode('
        {
          "$schema": "http://json-schema.org/draft-07/schema#",
          "$ref": "#/definitions/ExampleArray",
          "title": "",
          "definitions": {
            "NotEmptyString": {
              "type": "string",
              "title": "NotEmptyString",
              "minLength": 1,
              "additionalProperties": false
            },
            "Example": {
              "type": "object",
              "title": "Example",
              "additionalProperties": false,
              "properties": {
                "username": {
                  "type": "string"
                },
                "password": {
                  "type": "string"
                },
                "date-of-birth": {
                  "type": "string",
                  "format": "date"
                },
                "note": {
                  "$ref": "#/definitions/NotEmptyString"
                },
                "state": {
                  "const": "United states"
                },
                "newsletter": {
                  "const": true
                }
              },
              "required": [
                "username",
                "password"
              ]
            },
            "ExampleArray": {
              "type": "array",
              "title": "ExampleArray",
              "additionalProperties": false,
              "items": [
                {
                  "$ref": "#/definitions/Example"
                }
              ]
            }
          }
        }
        '), $schema->decode());

        $this->assertTrue($schema->validate(
            json_decode('[
                {
                     "username": "john Doe",
                     "password": "asdasd"
                },
                {
                     "username": "john Doe 2",
                     "password": "asdasd"
                }
            ]')
        ));
    }

}
