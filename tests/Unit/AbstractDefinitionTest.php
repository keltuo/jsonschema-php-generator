<?php declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Tests\Unit;

use JsonSchemaPhpGenerator\Definition\ExampleEnumValues as ExampleEnumValuesDefinition;
use JsonSchemaPhpGenerator\Definition\ExampleMergeOldNewDefinitionProperties;
use PHPUnit\Framework\TestCase;

/**
 * Class AbstractDefinitionTest
 * @package JsonSchemaPhpGenerator\Tests\Unit
 */
class AbstractDefinitionTest extends TestCase
{
    public function testCanThrowExceptionDecode()
    {
        $this->expectException(\JsonException::class);
        $this->expectExceptionMessage('Syntax error');
        $definition = $this->getMockForAbstractClass(
            '\JsonSchemaPhpGenerator\AbstractDefinition',
            [],
            '',
            true,
            true,
            true,
            [
                'getDefinition'
            ]
        );
        $definition->method('getDefinition')
            ->willReturn('{');
        $this->assertSame('{', $definition->getDefinition());
        json_decode($definition->getDefinition(), false, 512, JSON_THROW_ON_ERROR);
    }

    public function testGetEnumValues()
    {
        $definition = new ExampleEnumValuesDefinition();
        $this->assertSame([
            'ONE',
            'TWO'
        ], $definition->getEnumValues());

        $exclude = ['ONE'];
        $this->assertSame([
            1 => 'TWO'
        ], $definition->getEnumValues($exclude));
    }

}
