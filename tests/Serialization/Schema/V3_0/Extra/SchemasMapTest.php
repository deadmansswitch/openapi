<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenApi\Tests\Serialization\Schema\V3_0\Extra;

use DeadMansSwitch\OpenApi\Schema\V3_0\Extra\SchemasMap;
use DeadMansSwitch\OpenApi\Schema\V3_0\Schema;
use DeadMansSwitch\OpenApi\Serializer\SerializerFactory;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;

#[CoversNothing]
final class SchemasMapTest extends TestCase
{
    private SerializerInterface $serializer;

    protected function setUp(): void
    {
        $this->serializer = SerializerFactory::create();
    }

    #[DataProvider('data')]
    public function testDeserialize(string $json, SchemasMap $schema): void
    {
        $actual = $this->serializer->deserialize($json, SchemasMap::class, 'json');

        $this->assertEquals($schema, $actual);
    }

    #[DataProvider('data')]
    public function testSerialize(string $json, SchemasMap $schema): void
    {
        $actual = $this->serializer->serialize($schema, 'json');

        $this->assertJsonStringEqualsJsonString($json, $actual);
    }

    public static function data(): iterable
    {
        yield [
            'json' => '{
                "GeneralError": {
                    "type": "object",
                    "properties": {
                        "code": {
                            "type": "integer",
                            "format": "int32"
                        },
                        "message": {
                            "type": "string"
                        }
                    }
                },
                "Category": {
                    "type": "object",
                    "properties": {
                        "id": {
                            "type": "integer",
                            "format": "int64"
                        },
                        "name": {
                            "type": "string"
                        }
                    }
                },
                "Tag": {
                    "type": "object",
                    "properties": {
                        "id": {
                            "type": "integer",
                            "format": "int64"
                        },
                        "name": {
                            "type": "string"
                        }
                    }
                }
            }',
            'schema' => SchemasMap::fromArray([
                'GeneralError' => new Schema(
                    type: 'object',
                    properties: SchemasMap::fromArray([
                        'code' => new Schema(
                            type: 'integer',
                            format: 'int32'
                        ),
                        'message' => new Schema(
                            type: 'string'
                        ),
                    ]),
                ),
                'Category' => new Schema(
                    type: 'object',
                    properties: SchemasMap::fromArray([
                        'id' => new Schema(
                            type: 'integer',
                            format: 'int64'
                        ),
                        'name' => new Schema(
                            type: 'string'
                        ),
                    ]),
                ),
                'Tag' => new Schema(
                    type: 'object',
                    properties: SchemasMap::fromArray([
                        'id' => new Schema(
                            type: 'integer',
                            format: 'int64'
                        ),
                        'name' => new Schema(
                            type: 'string'
                        ),
                    ]),
                ),
            ]),
        ];
    }
}