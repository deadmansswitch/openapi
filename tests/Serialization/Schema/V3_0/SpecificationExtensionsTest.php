<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenApi\Tests\Serialization\Schema\V3_0;

use DeadMansSwitch\OpenApi\Schema\V3_0\SpecificationExtensions;
use DeadMansSwitch\OpenApi\Serializer\SerializerFactory;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;

#[CoversNothing]
final class SpecificationExtensionsTest extends TestCase
{
    private SerializerInterface $serializer;

    protected function setUp(): void
    {
        $this->serializer = SerializerFactory::create();
    }

    #[DataProvider('data')]
    public function testDeserialize(string $json, SpecificationExtensions $schema): void
    {
        $actual = $this->serializer->deserialize($json, SpecificationExtensions::class, 'json');

        $this->assertEquals($schema, $actual);
    }

    #[DataProvider('data')]
    public function testSerialize(string $json, SpecificationExtensions $schema): void
    {
        $actual = $this->serializer->serialize($schema, 'json');

        $this->assertJsonStringEqualsJsonString($json, $actual);
    }

    public static function data(): iterable
    {
        yield 'All good' => [
            'schema' => SpecificationExtensions::fromArray([
                'x-foo' => ['bar' => 'baz'],
                'x-string' => 'string-string-string',
                'x-bool-1' => true,
                'x-bool-2' => false,
                'x-int' => 42,
                'x-float' => 3.14,
            ]),
            'json' => '{
                "x-foo": {
                    "bar": "baz"
                },
                "x-string": "string-string-string",
                "x-bool-1": true,
                "x-bool-2": false,
                "x-int": 42,
                "x-float": 3.14
            }',
        ];
    }
}