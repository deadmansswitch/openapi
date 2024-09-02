<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenAPI\Tests\Serialization\Schema\V3_0;

use DeadMansSwitch\OpenAPI\Schema\V3_0\Extra\SchemasMap;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Reference;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Schema;
use DeadMansSwitch\OpenAPI\Serializer\SerializerFactory;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;

#[CoversNothing]
final class SchemaTest extends TestCase
{
    private SerializerInterface $serializer;

    protected function setUp(): void
    {
        $this->serializer = SerializerFactory::create();
    }

    #[DataProvider('data')]
    public function testDeserialize(string $json, Schema $schema): void
    {
        $actual = $this->serializer->deserialize($json, Schema::class, 'json');

        $this->assertEquals($schema, $actual);
    }

    #[DataProvider('data')]
    public function testSerialize(string $json, Schema $schema): void
    {
        $actual = $this->serializer->serialize($schema, 'json');

        $this->assertJsonStringEqualsJsonString($json, $actual);
    }

    public static function data(): iterable
    {
        yield [
            'json' => '{
                "type": "string",
                "format": "email"
            }',
            'schema' => new Schema(
                type: 'string',
                format: 'email',
            ),
        ];

        yield [
            'json' => '{
                "type": "object",
                "required": [
                    "name"
                ],
                "properties": {
                    "name": {
                        "type": "string"
                    },
                    "address": {
                        "$ref": "#/components/schemas/Address"
                    },
                    "age": {
                        "type": "integer",
                        "format": "int32",
                        "minimum": 0
                    }
                }
            }',
            'schema' => new Schema(
                type: 'object',
                required: [
                    'name',
                ],
                properties: SchemasMap::fromArray([
                    'name' => new Schema(
                        type: 'string',
                    ),
                    'address' => new Reference(
                        ref: '#/components/schemas/Address',
                    ),
                    'age' => new Schema(
                        type: 'integer',
                        format: 'int32',
                        minimum: 0,
                    ),
                ]),
            ),
        ];

        yield [
            'json' => '{
                "type": "object",
                "properties": {
                    "id": {
                        "type": "integer",
                        "format": "int64"
                    },
                    "name": {
                        "type": "string"
                    }
                },
                "required": [
                    "name"
                ],
                "example": {
                    "name": "Puma",
                    "id": 1
                }
            }',
            'schema' => new Schema(
                type: 'object',
                required: [
                    'name',
                ],
                properties: SchemasMap::fromArray([
                    'id' => new Schema(
                        type: 'integer',
                        format: 'int64',
                    ),
                    'name' => new Schema(
                        type: 'string',
                    ),
                ]),
                example: [
                    'name' => 'Puma',
                    'id' => 1,
                ],
            ),
        ];
    }
}