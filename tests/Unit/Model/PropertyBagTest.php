<?php declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Tests\Unit\Model;

use JsonSchemaPhpGenerator\Model\ItemBag;
use JsonSchemaPhpGenerator\Model\Property\IntegerProperty;
use JsonSchemaPhpGenerator\Model\Property\Length;
use JsonSchemaPhpGenerator\Model\Property\LengthItems;
use JsonSchemaPhpGenerator\Model\Property\NumberProperty;
use JsonSchemaPhpGenerator\Model\Property\Range;
use JsonSchemaPhpGenerator\Model\PropertyBag;
use PHPUnit\Framework\TestCase;

/**
 * Class PropertyBagTest
 * @package JsonSchemaPhpGenerator\Tests\Unit\Model
 */
class PropertyBagTest extends TestCase
{
    public function testSettersPropertiesAsModel()
    {
        $propertyBag = new PropertyBag();
        $propertyBag
            ->addString(
                'test-string',
                'test-description',
                null,
                new Length(1, 10),
                "^[0-9]{1,15}$"
            )
            ->addNumber(
                'test-number',
                '',
                new Range(1, 10, 1, 10),
                10
            )
            ->addInt(
                'test-int',
                '',
                new Range(1, 10, 1, 10),
                10
            )
            ->addReference('test-reference', '#/definitions/test')
            ->addBool('test-bool')
            ->addNull('test-null')
            ->addArray('test-array',
                (new ItemBag())
                    ->add(new NumberProperty())
                    ->add(new IntegerProperty()),
                '',
                new LengthItems(1, 100),
                '',
                true,
                false

            )
            ->addEnum('test-enum', ['ENUM1', 'ENUM2'], 'ENUM1')
            ->addMultipleType(
                'test-multiple-type',
                (new PropertyBag())
                    ->add(new NumberProperty())
                    ->add(new IntegerProperty())
            )
            ->addConst('test-const', 'string')
            ->addConst('test-const-bool', true)
            ->addAnyOf('test-anyOf',
                (new PropertyBag())
                ->add(new NumberProperty())
                ->add(new IntegerProperty())
            )
            ->addOneOf('test-oneOf',
                (new PropertyBag())
                ->add(new NumberProperty())
                ->add(new IntegerProperty())
            )
            ->addAllOf('test-allOf',
                (new PropertyBag())
                ->add(new NumberProperty())
                ->add(new IntegerProperty())
            );
        $expectedPropertyArray = [
            'test-string' => [
                'type' => 'string',
                'description' => 'test-description',
                'pattern' => '^[0-9]{1,15}$',
                'minLength' => 1,
                'maxLength' => 10
            ],
            'test-number' => [
                'type' => 'number',
                'minimum' => 1,
                'maximum' => 10,
                'exclusiveMinimum' => 1,
                'exclusiveMaximum' => 10,
                'multipleOf' => 10
            ],
            'test-int' => [
                'type' => 'integer',
                'minimum' => 1,
                'maximum' => 10,
                'exclusiveMinimum' => 1,
                'exclusiveMaximum' => 10,
                'multipleOf' => 10
            ],
            'test-reference' => [
                '$ref' => '#/definitions/test'
            ],
            'test-bool' => [
                'type' => 'boolean'
            ],
            'test-null' => [
                'type' => 'null'
            ],
            'test-array' => [
                'type' => 'array',
                'items' => [
                    ['type' => 'number'],
                    ['type' => 'integer'],
                ],
                'minItems' => 1,
                'maxItems' => 100,
                'uniqueItems' => true,
                'additionalItems' => false
            ],
            'test-enum' => [
                'enum' => [
                    'ENUM1',
                    'ENUM2'
                ],
                'default' => 'ENUM1'
            ],
            'test-multiple-type' => [
                'type' => ['number', 'integer'],
            ],
            'test-const' => [
                'const' => 'string',
            ],
            'test-const-bool' => [
                'const' => true,
            ],
            'test-anyOf' => [
                'anyOf' => [
                    ['type' => 'number'],
                    ['type' => 'integer'],
                ]
            ],
            'test-oneOf' => [
                'oneOf' => [
                    ['type' => 'number'],
                    ['type' => 'integer'],
                ]
            ],
            'test-allOf' => [
                'allOf' => [
                    ['type' => 'number'],
                    ['type' => 'integer'],
                ]
            ],
        ];
        $this->assertNotTrue($propertyBag->isEmpty());
        $this->assertSame(['type' => ['number', 'integer']], $propertyBag->get(8)?->toArray());
        $this->assertSame(14, count($propertyBag->toArray()));
        $this->assertSame($expectedPropertyArray, $propertyBag->toArray());
        $this->assertSame(json_encode($expectedPropertyArray), json_encode($propertyBag), 'JsonSerializable');
        $this->assertSame(json_encode($expectedPropertyArray), (string)$propertyBag, 'Stringable');
        $this->assertEquals(
            '{"test-string":{"type":"string","description":"test-description","pattern":"^[0-9]{1,15}$","minLength":1,"maxLength":10},"test-number":{"type":"number","minimum":1,"maximum":10,"exclusiveMinimum":1,"exclusiveMaximum":10,"multipleOf":10},"test-int":{"type":"integer","minimum":1,"maximum":10,"exclusiveMinimum":1,"exclusiveMaximum":10,"multipleOf":10},"test-reference":{"$ref":"#\/definitions\/test"},"test-bool":{"type":"boolean"},"test-null":{"type":"null"},"test-array":{"type":"array","items":[{"type":"number"},{"type":"integer"}],"minItems":1,"maxItems":100,"uniqueItems":true,"additionalItems":false},"test-enum":{"enum":["ENUM1","ENUM2"],"default":"ENUM1"},"test-multiple-type":{"type":["number","integer"]},"test-const":{"const":"string"},"test-const-bool":{"const":true},"test-anyOf":{"anyOf":[{"type":"number"},{"type":"integer"}]},"test-oneOf":{"oneOf":[{"type":"number"},{"type":"integer"}]},"test-allOf":{"allOf":[{"type":"number"},{"type":"integer"}]}}',
            (string)$propertyBag
        );
    }
}
