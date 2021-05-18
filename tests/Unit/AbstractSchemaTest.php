<?php declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Tests\Unit;

use JsonSchemaPhpGenerator\Definition\Example as ExampleDefinition;
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
                    }
                 },
                 "required":[
                    "username",
                    "password"
                 ]
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
                'context' => 94
            ]
        ], $errors);
    }

}
