<?php declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Tests\Unit\Model;

use JsonSchemaPhpGenerator\Model\ConditionalPropertyBag;
use JsonSchemaPhpGenerator\Model\ConditionsBag;
use JsonSchemaPhpGenerator\Model\DependenciesBag;
use JsonSchemaPhpGenerator\Model\Property\Length;

use PHPUnit\Framework\TestCase;

/**
 * Class DependenciesBagTest
 * @package JsonSchemaPhpGenerator\Tests\Unit\Model
 */
class DependenciesBagTest extends TestCase
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
        $dependenciesBag = (new DependenciesBag())
            ->add('propertyOne', 'propertyTwo')
            ->add('propertyOne', 'propertyThree')
            ->addConditionalProperty('propertyThree', $condPropertyBagOne);

        $expectedPropertyArray = [
            'propertyOne' => ['propertyTwo', 'propertyThree'],
            'propertyThree' => [
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
        ];
        $this->assertNotTrue($dependenciesBag->isEmpty());
        $this->assertSame(2, count($dependenciesBag->toArray()));
        $this->assertSame($expectedPropertyArray, $dependenciesBag->toArray());
        $this->assertSame(json_encode($expectedPropertyArray), json_encode($dependenciesBag), 'JsonSerializable');
        $this->assertSame(json_encode($expectedPropertyArray), (string)$dependenciesBag, 'Stringable');
        $this->assertEquals(
            '{"propertyOne":["propertyTwo","propertyThree"],"propertyThree":{"properties":{"test-string":{"type":"string","description":"test-description","pattern":"^[0-9]{1,15}$","minLength":1,"maxLength":10},"test-const":{"const":"string"}},"required":["test-string","test-const"]}}',
            (string)$dependenciesBag
        );
    }
}
