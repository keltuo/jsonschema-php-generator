<?php declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Tests\Unit\Model;

use JsonSchemaPhpGenerator\Model\ConditionalPropertyBag;
use JsonSchemaPhpGenerator\Model\Property\Length;

use PHPUnit\Framework\TestCase;

/**
 * Class ConditionalPropertyBagTest
 * @package JsonSchemaPhpGenerator\Tests\Unit\Model
 */
class ConditionalPropertyBagTest extends TestCase
{
    public function testSettersPropertiesAsModel()
    {
        $propertyBag = new ConditionalPropertyBag();
        $propertyBag
            ->addString(
                'test-string',
                'test-description',
                null,
                new Length(1, 10),
                "^[0-9]{1,15}$",
                true
            )
            ->addConst('test-const', 'string', '', true);
        $expectedPropertyArray = [
            'properties' => [
                'test-string' => [
                    'type' => 'string',
                    'description' => 'test-description',
                    'pattern' => '^[0-9]{1,15}$',
                    'minLength' => 1,
                    'maxLength' => 10
                ],
                'test-const' => [
                    'const' => 'string',
                ],
            ],
            'required' => [
                'test-string',
                'test-const'
            ]
        ];
        $this->assertNotTrue($propertyBag->isEmpty());
        $this->assertSame(2, count($propertyBag->toArray()));
        $this->assertSame($expectedPropertyArray, $propertyBag->toArray());
        $this->assertSame(json_encode($expectedPropertyArray), json_encode($propertyBag), 'JsonSerializable');
        $this->assertSame(json_encode($expectedPropertyArray), (string)$propertyBag, 'Stringable');
        $this->assertEquals(
            '{"properties":{"test-string":{"type":"string","description":"test-description","pattern":"^[0-9]{1,15}$","minLength":1,"maxLength":10},"test-const":{"const":"string"}},"required":["test-string","test-const"]}',
            (string)$propertyBag
        );
    }
}
