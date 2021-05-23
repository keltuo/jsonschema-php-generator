<?php declare(strict_types=1);

namespace JsonSchemaPhpGenerator\Tests\Unit\Model\Property;

use JsonSchemaPhpGenerator\Model\ItemBag;
use JsonSchemaPhpGenerator\Model\Property\Format\AbstractFormat;
use JsonSchemaPhpGenerator\Model\Property\Format\Date;
use JsonSchemaPhpGenerator\Model\Property\Format\DateTime;
use JsonSchemaPhpGenerator\Model\Property\Format\Email;
use JsonSchemaPhpGenerator\Model\Property\Format\Hostname;
use JsonSchemaPhpGenerator\Model\Property\Format\IdnEmail;
use JsonSchemaPhpGenerator\Model\Property\Format\IdnHostname;
use JsonSchemaPhpGenerator\Model\Property\Format\Ipv4;
use JsonSchemaPhpGenerator\Model\Property\Format\Ipv6;
use JsonSchemaPhpGenerator\Model\Property\Format\Iri;
use JsonSchemaPhpGenerator\Model\Property\Format\IriReference;
use JsonSchemaPhpGenerator\Model\Property\Format\JsonPointer;
use JsonSchemaPhpGenerator\Model\Property\Format\Regex;
use JsonSchemaPhpGenerator\Model\Property\Format\RelativeJsonPointer;
use JsonSchemaPhpGenerator\Model\Property\Format\Time;
use JsonSchemaPhpGenerator\Model\Property\Format\Uri;
use JsonSchemaPhpGenerator\Model\Property\Format\UriReference;
use JsonSchemaPhpGenerator\Model\Property\Format\UriTemplate;
use JsonSchemaPhpGenerator\Model\Property\IntegerProperty;
use JsonSchemaPhpGenerator\Model\Property\Length;
use JsonSchemaPhpGenerator\Model\Property\LengthItems;
use JsonSchemaPhpGenerator\Model\Property\NumberProperty;
use JsonSchemaPhpGenerator\Model\Property\Range;
use JsonSchemaPhpGenerator\Model\Property\StringProperty;
use JsonSchemaPhpGenerator\Model\PropertyBag;
use PHPUnit\Framework\TestCase;

/**
 * Class PropertyTest
 * @package JsonSchemaPhpGenerator\Tests\Unit\Model\Property
 */
class PropertyTest extends TestCase
{
    /**
     * @dataProvider propertyFormatData
     * @param string $formatType
     * @param string $formatClass
     */
    public function testProperties(string $formatType, string $formatClass)
    {
        $this->assertSame([
            'type' => 'string',
            'description' => 'test-description',
            'format' => $formatType,
        ], (new StringProperty(
            'test-string',
            'test-description',
            new $formatClass,
        ))->toArray());
    }

    public function propertyFormatData(): array
    {
        return [
            ['date', Date::class],
            ['date-time', DateTime::class],
            ['email', Email::class],
            ['hostname', Hostname::class],
            ['idn-email', IdnEmail::class],
            ['idn-hostname', IdnHostname::class],
            ['ipv4', Ipv4::class],
            ['ipv6', Ipv6::class],
            ['iri', Iri::class],
            ['iri-reference', IriReference::class],
            ['json-pointer', JsonPointer::class],
            ['regex', Regex::class],
            ['relative-json-pointer', RelativeJsonPointer::class],
            ['time', Time::class],
            ['uri', Uri::class],
            ['uri-reference', UriReference::class],
            ['uri-template', UriTemplate::class],
        ];
    }
}
