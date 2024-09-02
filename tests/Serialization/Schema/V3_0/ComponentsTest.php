<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenAPI\Tests\Serialization\Schema\V3_0;

use DeadMansSwitch\OpenAPI\Schema\V3_0\Components;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Enum\SecuritySchemeIn;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Enum\SecuritySchemeType;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Extra\MediaTypeMap;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Extra\ParametersMap;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Extra\SchemasMap;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Extra\SecuritySchemeMap;
use DeadMansSwitch\OpenAPI\Schema\V3_0\MediaType;
use DeadMansSwitch\OpenAPI\Schema\V3_0\OAuthFlow;
use DeadMansSwitch\OpenAPI\Schema\V3_0\OAuthFlows;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Parameter;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Reference;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Response;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Responses;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Schema;
use DeadMansSwitch\OpenAPI\Schema\V3_0\SecurityScheme;
use DeadMansSwitch\OpenAPI\Serializer\SerializerFactory;
use DeadMansSwitch\OpenAPI\Types\MapOfStrings;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;

#[CoversNothing]
final class ComponentsTest extends TestCase
{
    private SerializerInterface $serializer;

    protected function setUp(): void
    {
        $this->serializer = SerializerFactory::create();
    }

    #[DataProvider('data')]
    public function testDeserialize(string $json, Components $schema): void
    {
        $actual = $this->serializer->deserialize($json, Components::class, 'json');

        $this->assertEquals($schema, $actual);
    }

    #[DataProvider('data')]
    public function testSerialize(string $json, Components $schema): void
    {
        $actual = $this->serializer->serialize($schema, 'json');

        $this->assertJsonStringEqualsJsonString($json, $actual);
    }

    public static function data(): iterable
    {
        yield [
            'json' => '{
                "schemas": {
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
                },
                "parameters": {
                    "skipParam": {
                        "name": "skip",
                        "in": "query",
                        "description": "number of items to skip",
                        "required": true,
                        "schema": {
                            "type": "integer",
                            "format": "int32"
                        }
                    },
                    "limitParam": {
                        "name": "limit",
                        "in": "query",
                        "description": "max records to return",
                        "required": true,
                        "schema" : {
                            "type": "integer",
                            "format": "int32"
                        }
                    }
                },
                "responses": {
                    "NotFound": {
                        "description": "Entity not found."
                    },
                    "IllegalInput": {
                        "description": "Illegal input for operation."
                    },
                    "GeneralError": {
                        "description": "General Error",
                        "content": {
                            "application/json": {
                                "schema": {
                                    "$ref": "#/components/schemas/GeneralError"
                                }
                            }
                        }
                    }
                },
                "securitySchemes": {
                    "api_key": {
                        "type": "apiKey",
                        "name": "api_key",
                        "in": "header"
                    },
                    "petstore_auth": {
                        "type": "oauth2",
                        "flows": {
                            "implicit": {
                                "authorizationUrl": "https://example.org/api/oauth/dialog",
                                "scopes": {
                                    "write:pets": "modify pets in your account",
                                    "read:pets": "read your pets"
                                }
                            }
                        }
                    }
                }
            }',
            'schema' => new Components(
                schemas: SchemasMap::fromArray([
                    'GeneralError' => new Schema(
                        type: 'object',
                        properties: SchemasMap::fromArray([
                            'code' => new Schema(
                                type: 'integer',
                                format: 'int32',
                            ),
                            'message' => new Schema(
                                type: 'string',
                            ),
                        ]),
                    ),
                    'Category' => new Schema(
                        type: 'object',
                        properties: SchemasMap::fromArray([
                            'id' => new Schema(
                                type: 'integer',
                                format: 'int64',
                            ),
                            'name' => new Schema(
                                type: 'string',
                            ),
                        ]),
                    ),
                    'Tag' => new Schema(
                        type: 'object',
                        properties: SchemasMap::fromArray([
                            'id' => new Schema(
                                type: 'integer',
                                format: 'int64',
                            ),
                            'name' => new Schema(
                                type: 'string',
                            ),
                        ]),
                    ),
                ]),
                responses: Responses::fromArray([
                    'NotFound' => new Response(
                        description: 'Entity not found.',
                    ),
                    'IllegalInput' => new Response(
                        description: 'Illegal input for operation.',
                    ),
                    'GeneralError' => new Response(
                        description: 'General Error',
                        content: MediaTypeMap::fromArray([
                            'application/json' => new MediaType(
                                schema: new Reference(ref: '#/components/schemas/GeneralError'),
                            ),
                        ]),
                    ),
                ]),
                parameters: ParametersMap::fromArray([
                    'skipParam' => new Parameter(
                        name: 'skip',
                        in: 'query',
                        description: 'number of items to skip',
                        required: true,
                        schema: new Schema(
                            type: 'integer',
                            format: 'int32',
                        ),
                    ),
                    'limitParam' => new Parameter(
                        name: 'limit',
                        in: 'query',
                        description: 'max records to return',
                        required: true,
                        schema: new Schema(
                            type: 'integer',
                            format: 'int32',
                        ),
                    ),
                ]),
                securitySchemes: SecuritySchemeMap::fromArray([
                    'api_key' => new SecurityScheme(
                        type: SecuritySchemeType::ApiKey,
                        name: 'api_key',
                        in: SecuritySchemeIn::Header,
                    ),
                    'petstore_auth' => new SecurityScheme(
                        type: SecuritySchemeType::Oauth2,
                        flows: new OAuthFlows(
                            implicit: new OAuthFlow(
                                authorizationUrl: 'https://example.org/api/oauth/dialog',
                                scopes: MapOfStrings::fromArray([
                                    'write:pets' => 'modify pets in your account',
                                    'read:pets' => 'read your pets',
                                ]),
                            ),
                        ),
                    ),
                ]),
            ),
        ];
    }
}