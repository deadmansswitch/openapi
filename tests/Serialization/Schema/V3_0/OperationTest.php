<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenAPI\Tests\Serialization\Schema\V3_0;

use DeadMansSwitch\OpenAPI\Schema\V3_0\Extra\MediaTypeMap;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Extra\ParametersMap;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Extra\SchemasMap;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Extra\SecurityRequirementMap;
use DeadMansSwitch\OpenAPI\Schema\V3_0\MediaType;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Operation;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Parameter;
use DeadMansSwitch\OpenAPI\Schema\V3_0\RequestBody;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Response;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Responses;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Schema;
use DeadMansSwitch\OpenAPI\Schema\V3_0\SecurityRequirement;
use DeadMansSwitch\OpenAPI\Serializer\SerializerFactory;
use DeadMansSwitch\OpenAPI\Types\MapOfStrings;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;

#[CoversNothing]
final class OperationTest extends TestCase
{
    private SerializerInterface $serializer;

    protected function setUp(): void
    {
        $this->serializer = SerializerFactory::create();
    }

    #[DataProvider('data')]
    public function testDeserialize(string $json, Operation $schema): void
    {
        $actual = $this->serializer->deserialize($json, Operation::class, 'json');

        $this->assertEquals($schema, $actual);
    }

    #[DataProvider('data')]
    public function testSerialize(string $json, Operation $schema): void
    {
        $actual = $this->serializer->serialize($schema, 'json');

        $this->assertJsonStringEqualsJsonString($json, $actual);
    }

    public static function data(): iterable
    {
        yield [
            'json' => '{
                "tags": [
                    "pet"
                ],
                "summary": "Updates a pet in the store with form data",
                "operationId": "updatePetWithForm",
                "parameters": [
                    {
                        "name": "petId",
                        "in": "path",
                        "description": "ID of pet that needs to be updated",
                        "required": true,
                        "schema": {
                            "type": "string"
                        }
                    }
                ],
                "requestBody": {
                    "content": {
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
                    }
                },
                "responses": {
                    "200": {
                        "description": "Pet updated.",
                        "content": {
                            "application/json": {},
                            "application/xml": {}
                        }
                    },
                    "405": {
                        "description": "Method Not Allowed",
                        "content": {
                            "application/json": {},
                            "application/xml": {}
                        }
                    }
                },
                "security": [
                    {
                        "petstore_auth": [
                            "write:pets",
                            "read:pets"
                        ]
                    }
                ]
            }',
            'schema' => new Operation(
                tags: MapOfStrings::fromArray(['pet']),
                summary: 'Updates a pet in the store with form data',
                operationId: 'updatePetWithForm',
                parameters: ParametersMap::fromArray([
                    new Parameter(
                        name: 'petId',
                        in: 'path',
                        description: 'ID of pet that needs to be updated',
                        required: true,
                        schema: new Schema(type: 'string'),
                    ),
                ]),
                requestBody: new RequestBody(
                    content: MediaTypeMap::fromArray([
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
                ),
                responses: Responses::fromArray([
                    '200' => new Response(
                        description: 'Pet updated.',
                        content: MediaTypeMap::fromArray([
                            'application/json' => new MediaType(),
                            'application/xml' => new MediaType(),
                        ]),
                    ),
                    '405' => new Response(
                        description: 'Method Not Allowed',
                        content: MediaTypeMap::fromArray([
                            'application/json' => new MediaType(),
                            'application/xml' => new MediaType(),
                        ]),
                    ),
                ]),
                security: SecurityRequirementMap::fromArray([
                    SecurityRequirement::fromArray([
                        'petstore_auth' => [
                            'write:pets',
                            'read:pets',
                        ],
                    ]),
                ]),
            ),
        ];
    }
}