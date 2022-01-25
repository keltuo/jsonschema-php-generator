<?php declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Tests\Unit;

use JsonSchemaPhpGenerator\ErrorModel;
use JsonSchemaPhpGenerator\ErrorWrapper;
use PHPUnit\Framework\TestCase;

/**
 * Class ErrorWrapperTest
 * @package JsonSchemaPhpGenerator\Tests\Unit
 */
class ErrorWrapperTest extends TestCase
{
    /**
     * @throws \ReflectionException
     */
    public function testErrors()
    {
        $wrapper = new ErrorWrapper([
            [
                'property' => "string1",
                'pointer' => "string1",
                'message' => "string1",
                'constraint' => [
                    'name' => 'required',
                    'params' => [
                        'property' => 'string1'
                    ]
                ],
                'context' => 1
            ],
            [
                'property' => "string2",
                'pointer' => "string2",
                'message' => "string2",
                'constraint' => [
                    'name' => 'required',
                    'params' => [
                        'property' => 'string2'
                    ]
                ],
                'context' => 2
            ]
        ]);
        $this->assertCount(2, $wrapper->getErrors());
        $this->assertCount(2, $wrapper);
        $this->assertInstanceOf(
            ErrorModel::class,
            $wrapper->createError([
                'property' => "string2",
                'pointer' => "string2",
                'message' => "string2",
                'constraint' => [
                    'name' => 'required',
                    'params' => [
                        'property' => 'string2'
                    ]
                ],
                'context' => 2
            ])
        );
    }
}
