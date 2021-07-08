<?php declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Tests\Unit\Model;

use JsonSchemaPhpGenerator\Model\ConditionalPropertyBag;
use JsonSchemaPhpGenerator\Model\ConditionsBag;
use JsonSchemaPhpGenerator\Model\Property\Length;

use PHPUnit\Framework\TestCase;

/**
 * Class ConditionsBagTest
 * @package JsonSchemaPhpGenerator\Tests\Unit\Model
 */
class ConditionsBagTest extends TestCase
{
    public function testSettersPropertiesAsModel()
    {
        $condPropertyBagOne = (new ConditionalPropertyBag())
            ->addString(
                'test-string',
                'test-description',
                null,
                new Length(1, 10),
                "^[0-9]{1,15}$",
                true
            )
            ->addConst('test-const', 'string', '', true);
        $condPropertyBagTwo = (new ConditionalPropertyBag())
            ->addString(
                'test-string',
                'test-description',
                null,
                new Length(1, 10),
                "^[0-9]{1,15}$",
                false
            );
        $conditionsBag = (new ConditionsBag())
            ->add($condPropertyBagOne)
            ->add($condPropertyBagTwo);

        $expectedPropertyArray = [
            [
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
            ],
            [
                'properties' => [
                    'test-string' => [
                        'type' => 'string',
                        'description' => 'test-description',
                        'pattern' => '^[0-9]{1,15}$',
                        'minLength' => 1,
                        'maxLength' => 10
                    ],
                ]
            ]
        ];
        $this->assertNotTrue($conditionsBag->isEmpty());
        $this->assertSame(2, count($conditionsBag->toArray()));
        $this->assertSame($expectedPropertyArray, $conditionsBag->toArray());
        $this->assertSame(json_encode($expectedPropertyArray), json_encode($conditionsBag), 'JsonSerializable');
        $this->assertSame(json_encode($expectedPropertyArray), (string)$conditionsBag, 'Stringable');
        $this->assertEquals(
            '[{"properties":{"test-string":{"type":"string","description":"test-description","pattern":"^[0-9]{1,15}$","minLength":1,"maxLength":10},"test-const":{"const":"string"}},"required":["test-string","test-const"]},{"properties":{"test-string":{"type":"string","description":"test-description","pattern":"^[0-9]{1,15}$","minLength":1,"maxLength":10}}}]',
            (string)$conditionsBag
        );
    }
}
