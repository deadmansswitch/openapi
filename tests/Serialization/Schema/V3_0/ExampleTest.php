<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenAPI\Tests\Serialization\Schema\V3_0;

use DeadMansSwitch\OpenAPI\Schema\V3_0\Example;
use DeadMansSwitch\OpenAPI\Serializer\SerializerFactory;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;

#[CoversNothing]
final class ExampleTest extends TestCase
{
    private SerializerInterface $serializer;

    protected function setUp(): void
    {
        $this->serializer = SerializerFactory::create();
    }

    #[DataProvider('deserializeDataProvider')]
    public function testDeserialize(string $json, ?Example $schema, ?string $exception = null)
    {
        if ($exception !== null) {
            $this->expectException($exception);
        }

        $actual = $this->serializer->deserialize($json, Example::class, 'json');

        $this->assertEquals($schema, $actual);
    }

    public static function deserializeDataProvider(): iterable
    {
        yield 'In Request body: Official example #1' => [
            'json' => '{
                "summary": "This is an example in XML",
                "externalValue": "https://example.org/examples/address-example.xml"
            }',
            'schema' => new Example(
                summary: 'This is an example in XML',
                externalValue: 'https://example.org/examples/address-example.xml',
            ),
        ];

        yield 'In Request body: Official example #2' => [
            'json' => '{
                "summary": "This is a text example",
                "externalValue": "https://foo.bar/examples/address-example.txt"
            }',
            'schema' => new Example(
                summary: 'This is a text example',
                externalValue: 'https://foo.bar/examples/address-example.txt',
            ),
        ];
    }

    #[DataProvider('serializeDataProvider')]
    public function testSerialize(Example $schema, ?string $json = null, ?string $exception = null): void
    {
        if ($exception !== null) {
            $this->expectException($exception);
        }

        $actual = $this->serializer->serialize($schema, 'json');

        $this->assertJsonStringEqualsJsonString($json, $actual);
    }

    public static function serializeDataProvider(): iterable
    {
        yield 'All good' => [
            'schema' => new Example(
                summary: 'This is an example in XML',
                externalValue: 'https://example.org/examples/address-example.xml',
            ),
            'json' => '{
                "summary": "This is an example in XML",
                "externalValue": "https://example.org/examples/address-example.xml"
            }',
        ];
    }
}