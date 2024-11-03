<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenApi\Tests\Serialization\Schema\V3_0;

use DeadMansSwitch\OpenApi\Schema\V3_0\Extra\MediaTypeMap;
use DeadMansSwitch\OpenApi\Schema\V3_0\Extra\ParametersMap;
use DeadMansSwitch\OpenApi\Schema\V3_0\MediaType;
use DeadMansSwitch\OpenApi\Schema\V3_0\Operation;
use DeadMansSwitch\OpenApi\Schema\V3_0\Parameter;
use DeadMansSwitch\OpenApi\Schema\V3_0\PathItem;
use DeadMansSwitch\OpenApi\Schema\V3_0\Reference;
use DeadMansSwitch\OpenApi\Schema\V3_0\Response;
use DeadMansSwitch\OpenApi\Schema\V3_0\Responses;
use DeadMansSwitch\OpenApi\Schema\V3_0\Schema;
use DeadMansSwitch\OpenApi\Serializer\SerializerFactory;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;

#[CoversNothing]
final class PathItemTest extends TestCase
{
    private SerializerInterface $serializer;

    protected function setUp(): void
    {
        $this->serializer = SerializerFactory::create();
    }

    #[DataProvider('data')]
    public function testDeserialize(string $json, PathItem $schema): void
    {
        $actual = $this->serializer->deserialize($json, PathItem::class, 'json');

        $this->assertEquals($schema, $actual);
    }

    #[DataProvider('data')]
    public function testSerialize(string $json, PathItem $schema): void
    {
        $actual = $this->serializer->serialize($schema, 'json');

        $this->assertJsonStringEqualsJsonString($json, $actual);
    }

    public static function data(): iterable
    {
        yield [
            'json' => '{
                "get": {
                    "description": "Returns pets based on ID",
                    "summary": "Find pets by ID",
                    "operationId": "getPetsById",
                    "responses": {
                        "200": {
                            "description": "pet response",
                            "content": {
                                "*/*": {
                                    "schema": {
                                        "type": "array",
                                        "items": {
                                            "$ref": "#/components/schemas/Pet"
                                        }
                                    }
                                }
                            }
                        },
                        "default": {
                            "description": "error payload",
                            "content": {
                                "text/html": {
                                    "schema": {
                                        "$ref": "#/components/schemas/ErrorModel"
                                    }
                                }
                            }
                        }
                    }
                },
                "parameters": [
                    {
                        "name": "id",
                        "in": "path",
                        "description": "ID of pet to use",
                        "required": true,
                        "schema": {
                            "type": "array",
                            "items": {
                                "type": "string"
                            }
                        },
                        "style": "simple"
                    }
                ]
            }',
            'schema' => new PathItem(
                get: new Operation(
                    summary: 'Find pets by ID',
                    description: 'Returns pets based on ID',
                    operationId: 'getPetsById',
                    responses: Responses::fromArray([
                        '200' => new Response(
                            description: 'pet response',
                            content: MediaTypeMap::fromArray([
                                '*/*' => new MediaType(
                                    schema: new Schema(
                                        type: 'array',
                                        items: new Reference(ref: '#/components/schemas/Pet'),
                                    ),
                                ),
                            ]),
                        ),
                        'default' => new Response(
                            description: 'error payload',
                            content: MediaTypeMap::fromArray([
                                'text/html' => new MediaType(
                                    schema: new Reference(ref: '#/components/schemas/ErrorModel'),
                                ),
                            ]),
                        ),
                    ]),
                ),
                parameters: ParametersMap::fromArray([
                    new Parameter(
                        name: 'id',
                        in: 'path',
                        description: 'ID of pet to use',
                        required: true,
                        style: 'simple',
                        schema: new Schema(
                            type: 'array',
                            items: new Schema(type: 'string'),
                        ),
                    ),
                ]),
            ),
        ];
    }
}