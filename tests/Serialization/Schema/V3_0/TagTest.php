<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenAPI\Tests\Serialization\Schema\V3_0;

use DeadMansSwitch\OpenAPI\Schema\V3_0\Tag;
use DeadMansSwitch\OpenAPI\Serializer\SerializerFactory;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;

#[CoversNothing]
final class TagTest extends TestCase
{
    private SerializerInterface $serializer;

    protected function setUp(): void
    {
        $this->serializer = SerializerFactory::create();
    }

    #[DataProvider('dataProvider')]
    public function testDeserialize(string $json, ?Tag $expected = null, ?string $exception = null): void
    {
        if ($exception !== null) {
            $this->expectException($exception);
        }

        $actual = $this->serializer->deserialize($json, Tag::class, 'json');

        $this->assertEquals($expected, $actual);
    }

    public static function dataProvider(): iterable
    {
        yield 'Official example #1' => [
            'json' => '{
	            "name": "pet",
	            "description": "Pets operations"
            }',
            'expected' => new Tag(
                name: 'pet',
                description: 'Pets operations',
            ),
        ];
    }

    #[DataProvider('deserializeDataProvider')]
    public function testSerialize(Tag $schema, ?string $json = null, ?string $exception = null): void
    {
        if ($exception !== null) {
            $this->expectException($exception);
        }

        $actual = $this->serializer->serialize($schema, 'json');

        $this->assertJsonStringEqualsJsonString($json, $actual);
    }

    public static function deserializeDataProvider(): iterable
    {
        yield 'All good' => [
            'schema' => new Tag(
                name: 'pet',
                description: 'Pets operations',
            ),
            'json' => '{
                "name": "pet",
                "description": "Pets operations"
            }',
        ];
    }
}