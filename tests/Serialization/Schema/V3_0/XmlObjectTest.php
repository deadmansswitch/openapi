<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenApi\Tests\Serialization\Schema\V3_0;

use DeadMansSwitch\OpenApi\Schema\V3_0\XmlObject;
use DeadMansSwitch\OpenApi\Serializer\SerializerFactory;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;

#[CoversNothing]
final class XmlObjectTest extends TestCase
{
    private SerializerInterface $serializer;

    protected function setUp(): void
    {
        $this->serializer = SerializerFactory::create();
    }

    #[DataProvider('deserializeDataProvider')]
    public function testDeserialize(string $json, ?XmlObject $schema = null, ?string $exception = null): void
    {
        if ($exception !== null) {
            $this->expectException($exception);
        }

        $result = $this->serializer->deserialize($json, XmlObject::class, 'json');

        $this->assertEquals($schema, $result);
    }

    public static function deserializeDataProvider(): iterable
    {
        yield 'Official Example #1' => [
            'json' => '{
                "name": "animal"
            }',
            'schema' => new XmlObject(
                name: 'animal',
            ),
        ];

        yield 'Official Example #2' => [
            'json' => '{
                "name": "animal",
                "namespace": "https://example.com/schema"
            }',
            'schema' => new XmlObject(
                name: 'animal',
                namespace: 'https://example.com/schema',
            ),
        ];
    }

    #[DataProvider('serializeDataProvider')]
    public function testSerialize(XmlObject $schema, ?string $json = null, ?string $exception = null): void
    {
        if ($exception !== null) {
            $this->expectException($exception);
        }

        $result = $this->serializer->serialize($schema, 'json');

        $this->assertJsonStringEqualsJsonString($json, $result);
    }

    public static function serializeDataProvider(): iterable
    {
        yield 'All Good' => [
            'schema' => new XmlObject(
                name: 'animal',
                namespace: 'https://example.com/schema',
            ),
            'json' => '{
                "name": "animal",
                "namespace": "https://example.com/schema",
                "attribute": false,
                "wrapped": false
            }',
        ];
    }
}