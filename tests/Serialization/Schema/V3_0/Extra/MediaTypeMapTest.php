<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenAPI\Tests\Serialization\Schema\V3_0\Extra;

use DeadMansSwitch\OpenAPI\Schema\V3_0\Extra\MediaTypeMap;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Extra\SchemasMap;
use DeadMansSwitch\OpenAPI\Schema\V3_0\MediaType;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Reference;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Schema;
use DeadMansSwitch\OpenAPI\Serializer\SerializerFactory;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;

#[CoversNothing]
final class MediaTypeMapTest extends TestCase
{
    private SerializerInterface $serializer;

    protected function setUp(): void
    {
        $this->serializer = SerializerFactory::create();
    }

    #[DataProvider('data')]
    public function testDeserialize(string $json, MediaTypeMap $schema): void
    {
        $actual = $this->serializer->deserialize($json, MediaTypeMap::class, 'json');

        $this->assertEquals($schema, $actual);
    }

    #[DataProvider('data')]
    public function testSerialize(string $json, MediaTypeMap $schema): void
    {
        $actual = $this->serializer->serialize($schema, 'json');

        $this->assertJsonStringEqualsJsonString($json, $actual);
    }

    public static function data(): iterable
    {
        yield [
            'json' => '{
                "application/json": {
                    "schema": {
                        "$ref": "#/components/schemas/Example"
                    }
                }
            }',
            'schema' => MediaTypeMap::fromArray([
                'application/json' => new MediaType(
                    schema: new Reference('#/components/schemas/Example')
                ),
            ]),
        ];

        yield [
            'json' => '{
                "application/json": {
                    "schema": {
                        "type": "array",
                        "items": {
                            "$ref": "#/components/schemas/pet"
                        }
                    }
                }
            }',
            'schema' => MediaTypeMap::fromArray([
                'application/json' => new MediaType(
                    schema: new Schema(
                        type: 'array',
                        items: new Reference(ref: '#/components/schemas/pet'),
                    ),
                ),
            ]),
        ];

        yield [
            'json' => '{
                "application/x-www-form-urlencoded": {
                    "schema": {
                        "type": "object",
                        "properties": {
                            "name": {
                                "description": "Updated name of the pet",
                                "type": "string"
                            },
                            "status": {
                                "description": "Updated status of the pet",
                                "type": "string"
                            }
                        },
                        "required": ["status"]
                    }
                }
            }',
            'schema' => MediaTypeMap::fromArray([
                'application/x-www-form-urlencoded' => new MediaType(
                    schema: new Schema(
                        type: 'object',
                        required: ['status'],
                        properties: SchemasMap::fromArray([
                            'name' => new Schema(
                                type: 'string',
                                description: 'Updated name of the pet',
                            ),
                            'status' => new Schema(
                                type: 'string',
                                description: 'Updated status of the pet',
                            ),
                        ]),
                    ),
                ),
            ]),
        ];
    }
}