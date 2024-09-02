<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenAPI\Tests\Serialization\Schema\V3_0;

use DeadMansSwitch\OpenAPI\Schema\V3_0\ExternalDocumentation;
use DeadMansSwitch\OpenAPI\Serializer\SerializerFactory;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;

#[CoversNothing]
final class ExternalDocumentationTest extends TestCase
{
    private SerializerInterface $serializer;

    protected function setUp(): void
    {
        $this->serializer = SerializerFactory::create();
    }

    #[DataProvider('deserializeDataProvider')]
    public function testDeserialize(string $json, ?ExternalDocumentation $expected = null, ?string $exception = null): void
    {
        if ($exception !== null) {
            $this->expectException($exception);
        }

        $actual = $this->serializer->deserialize($json, ExternalDocumentation::class, 'json');

        $this->assertEquals($expected, $actual);
    }

    public static function deserializeDataProvider(): iterable
    {
        yield 'Official example: External Documentation Object Example' => [
            'json' => '{
                "description": "Find more info here",
                "url": "https://example.com"
            }',
            'expected' => new ExternalDocumentation(
                description: 'Find more info here',
                url: 'https://example.com'
            )
        ];

        yield 'Mandatory property `url` is missed' => [
            'json' => '{
                "description": "Find more info here"
            }',
            'exception' => 'Symfony\Component\Serializer\Exception\MissingConstructorArgumentsException'
        ];
    }

    #[DataProvider('serializeDataProvider')]
    public function testSerialize(ExternalDocumentation $schema, ?string $json = null, ?string $exception = null): void
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
            'schema' => new ExternalDocumentation(
                description: 'Find more info here',
                url: 'https://example.com'
            ),
            'json' => '{
                "description": "Find more info here",
                "url": "https://example.com"
            }'
        ];
    }
}