<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenAPI\Tests\Serialization\Schema\V3_0;

use DeadMansSwitch\OpenAPI\Schema\V3_0\Components;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Extra\HeadersMap;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Extra\MediaTypeMap;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Extra\ParametersMap;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Extra\SchemasMap;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Extra\ServerMap;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Header;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Info;
use DeadMansSwitch\OpenAPI\Schema\V3_0\License;
use DeadMansSwitch\OpenAPI\Schema\V3_0\MediaType;
use DeadMansSwitch\OpenAPI\Schema\V3_0\OpenApi;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Operation;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Parameter;
use DeadMansSwitch\OpenAPI\Schema\V3_0\PathItem;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Paths;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Reference;
use DeadMansSwitch\OpenAPI\Schema\V3_0\RequestBody;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Response;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Responses;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Schema;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Server;
use DeadMansSwitch\OpenAPI\Serializer\SerializerFactory;
use DeadMansSwitch\OpenAPI\Types\MapOfStrings;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;

#[CoversNothing]
final class OpenApiTest extends TestCase
{
    private SerializerInterface $serializer;

    protected function setUp(): void
    {
        $this->serializer = SerializerFactory::create();
    }

    #[DataProvider('data')]
    public function testDeserialize(string $json, OpenApi $schema): void
    {
        $actual = $this->serializer->deserialize($json, OpenApi::class, 'json');

        $this->assertEquals($schema, $actual);
    }

    #[DataProvider('data')]
    public function testSerialize(string $json, OpenApi $schema): void
    {
        $actual = $this->serializer->serialize($schema, 'json');

        $this->assertJsonStringEqualsJsonString($json, $actual);
    }

    public static function data(): iterable
    {
        yield 'Pet Store' => [
            'json' => '{
                "openapi": "3.0.0",
                "info": {
                    "version": "1.0.0",
                    "title": "Swagger Petstore",
                    "license": {
                        "name": "MIT",
                        "url": "https://opensource.org/licenses/MIT"
                    }
                },
                "servers": [
                    {
                        "url": "http://petstore.swagger.io/v1"
                    }
                ],
                "paths": {
                    "/pets": {
                        "get": {
                            "summary": "List all pets",
                            "operationId": "listPets",
                            "tags": [
                                "pets"
                            ],
                            "parameters": [
                                {
                                    "name": "limit",
                                    "in": "query",
                                    "description": "How many items to return at one time (max 100)",
                                    "required": false,
                                    "schema": {
                                        "type": "integer",
                                        "format": "int32"
                                    }
                                }
                            ],
                            "responses": {
                                "200": {
                                    "description": "A paged array of pets",
                                    "headers": {
                                        "x-next": {
                                            "description": "A link to the next page of responses",
                                            "schema": {
                                                "type": "string"
                                            }
                                        }
                                    },
                                    "content": {
                                        "application/json": {
                                            "schema": {
                                                "$ref": "#/components/schemas/Pets"
                                            }
                                        }
                                    }
                                },
                                "default": {
                                    "description": "unexpected error",
                                    "content": {
                                        "application/json": {
                                            "schema": {
                                                "$ref": "#/components/schemas/Error"
                                            }
                                        }
                                    }
                                }
                            }
                        },
                        "post": {
                            "summary": "Create a pet",
                            "operationId": "createPets",
                            "tags": [
                                "pets"
                            ],
                            "responses": {
                                "201": {
                                    "description": "Null response"
                                },
                                "default": {
                                    "description": "unexpected error",
                                    "content": {
                                        "application/json": {
                                            "schema": {
                                                "$ref": "#/components/schemas/Error"
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    },
                    "/pets/{petId}": {
                        "get": {
                            "summary": "Info for a specific pet",
                            "operationId": "showPetById",
                            "tags": [
                                "pets"
                            ],
                            "parameters": [
                                {
                                    "name": "petId",
                                    "in": "path",
                                    "required": true,
                                    "description": "The id of the pet to retrieve",
                                    "schema": {
                                        "type": "string"
                                    }
                                }
                            ],
                            "responses": {
                                "200": {
                                    "description": "Expected response to a valid request",
                                    "content": {
                                        "application/json": {
                                            "schema": {
                                                "$ref": "#/components/schemas/Pet"
                                            }
                                        }
                                    }
                                },
                                "default": {
                                    "description": "unexpected error",
                                    "content": {
                                        "application/json": {
                                            "schema": {
                                                "$ref": "#/components/schemas/Error"
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                },
                "components": {
                    "schemas": {
                        "Pet": {
                            "type": "object",
                            "required": [
                                "id",
                                "name"
                            ],
                            "properties": {
                                "id": {
                                    "type": "integer",
                                    "format": "int64"
                                },
                                "name": {
                                    "type": "string"
                                },
                                "tag": {
                                    "type": "string"
                                }
                            }
                        },
                        "Pets": {
                            "type": "array",
                            "items": {
                                "$ref": "#/components/schemas/Pet"
                            }
                        },
                        "Error": {
                            "type": "object",
                            "required": [
                                "code",
                                "message"
                            ],
                            "properties": {
                                "code": {
                                    "type": "integer",
                                    "format": "int32"
                                },
                                "message": {
                                    "type": "string"
                                }
                            }
                        }
                    }
                }
            }',
            'schema' => new OpenApi(
                openapi: '3.0.0',
                info: new Info(
                    title: 'Swagger Petstore',
                    version: '1.0.0',
                    license: new License(
                        name: 'MIT',
                        url: 'https://opensource.org/licenses/MIT',
                    ),
                ),
                servers: ServerMap::fromArray([
                    new Server(url: 'http://petstore.swagger.io/v1'),
                ]),
                paths: Paths::fromArray([
                    '/pets' => new PathItem(
                        get: new Operation(
                            tags: MapOfStrings::fromArray(['pets']),
                            summary: 'List all pets',
                            operationId: 'listPets',
                            parameters: ParametersMap::fromArray([
                                new Parameter(
                                    name: 'limit',
                                    in: 'query',
                                    description: 'How many items to return at one time (max 100)',
                                    required: false,
                                    schema: new Schema(
                                        type: 'integer',
                                        format: 'int32',
                                    ),
                                ),
                            ]),
                            responses: Responses::fromArray([
                                '200' => new Response(
                                    description: 'A paged array of pets',
                                    headers: HeadersMap::fromArray([
                                        'x-next' => new Header(
                                            description: 'A link to the next page of responses',
                                            schema: new Schema(
                                                type: 'string',
                                            ),
                                        ),
                                    ]),
                                    content: MediaTypeMap::fromArray([
                                        'application/json' => new MediaType(
                                            schema: new Reference(
                                                ref: '#/components/schemas/Pets',
                                            ),
                                        ),
                                    ]),
                                ),
                                'default' => new Response(
                                    description: 'unexpected error',
                                    content: MediaTypeMap::fromArray([
                                        'application/json' => new MediaType(
                                            schema: new Reference(
                                                ref: '#/components/schemas/Error',
                                            ),
                                        ),
                                    ]),
                                ),
                            ]),
                        ),
                        post: new Operation(
                            tags: MapOfStrings::fromArray(['pets']),
                            summary: 'Create a pet',
                            operationId: 'createPets',
                            responses: Responses::fromArray([
                                '201' => new Response(
                                    description: 'Null response',
                                ),
                                'default' => new Response(
                                    description: 'unexpected error',
                                    content: MediaTypeMap::fromArray([
                                        'application/json' => new MediaType(
                                            schema: new Reference(
                                                ref: '#/components/schemas/Error',
                                            ),
                                        ),
                                    ]),
                                ),
                            ]),
                        ),
                    ),
                    '/pets/{petId}' => new PathItem(
                        get: new Operation(
                            tags: MapOfStrings::fromArray(['pets']),
                            summary: 'Info for a specific pet',
                            operationId: 'showPetById',
                            parameters: ParametersMap::fromArray([
                                new Parameter(
                                    name: 'petId',
                                    in: 'path',
                                    description: 'The id of the pet to retrieve',
                                    required: true,
                                    schema: new Schema(
                                        type: 'string',
                                    ),
                                ),
                            ]),
                            responses: Responses::fromArray([
                                '200' => new Response(
                                    description: 'Expected response to a valid request',
                                    content: MediaTypeMap::fromArray([
                                        'application/json' => new MediaType(
                                            schema: new Reference(
                                                ref: '#/components/schemas/Pet',
                                            ),
                                        ),
                                    ]),
                                ),
                                'default' => new Response(
                                    description: 'unexpected error',
                                    content: MediaTypeMap::fromArray([
                                        'application/json' => new MediaType(
                                            schema: new Reference(
                                                ref: '#/components/schemas/Error',
                                            ),
                                        ),
                                    ]),
                                ),
                            ]),
                        ),
                    ),
                ]),
                components: new Components(
                    schemas: SchemasMap::fromArray([
                        'Pet' => new Schema(
                            type: 'object',
                            required: ['id', 'name'],
                            properties: SchemasMap::fromArray([
                                'id' => new Schema(
                                    type: 'integer',
                                    format: 'int64',
                                ),
                                'name' => new Schema(
                                    type: 'string',
                                ),
                                'tag' => new Schema(
                                    type: 'string',
                                ),
                            ]),
                        ),
                        'Pets' => new Schema(
                            type: 'array',
                            items: new Reference(
                                ref: '#/components/schemas/Pet',
                            ),
                        ),
                        'Error' => new Schema(
                            type: 'object',
                            required: ['code', 'message'],
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
                    ]),
                ),
            ),
        ];

        yield 'AWS: Amazon Bedrock OAS example' => [
            'json' => '{
                "openapi": "3.0.0",
                "info": {
                    "title": "Insurance Claims Automation API",
                    "version": "1.0.0",
                    "description": "APIs for managing insurance claims by pulling a list of open claims, identifying outstanding paperwork for each claim, and sending reminders to policy holders."
                },
                "paths": {
                    "/claims": {
                        "get": {
                            "summary": "Get a list of all open claims",
                            "description": "Get the list of all open insurance claims. Return all the open claimIds.",
                            "operationId": "getAllOpenClaims",
                            "responses": {
                                "200": {
                                    "description": "Gets the list of all open insurance claims for policy holders",
                                    "content": {
                                        "application/json": {
                                            "schema": {
                                                "type": "array",
                                                "items": {
                                                    "type": "object",
                                                    "properties": {
                                                        "claimId": {
                                                            "type": "string",
                                                            "description": "Unique ID of the claim."
                                                        },
                                                        "policyHolderId": {
                                                            "type": "string",
                                                            "description": "Unique ID of the policy holder who has filed the claim."
                                                        },
                                                        "claimStatus": {
                                                            "type": "string",
                                                            "description": "The status of the claim. Claim can be in Open or Closed state"
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    },
                    "/claims/{claimId}/identify-missing-documents": {
                        "get": {
                            "summary": "Identify missing documents for a specific claim",
                            "description": "Get the list of pending documents that need to be uploaded by policy holder before the claim can be processed. The API takes in only one claim id and returns the list of documents that are pending to be uploaded by policy holder for that claim. This API should be called for each claim id",
                            "operationId": "identifyMissingDocuments",
                            "parameters": [
                                {
                                    "name": "claimId",
                                    "in": "path",
                                    "description": "Unique ID of the open insurance claim",
                                    "required": true,
                                    "schema": {
                                        "type": "string"
                                    }
                                }
                            ],
                            "responses": {
                                "200": {
                                    "description": "List of documents that are pending to be uploaded by policy holder for insurance claim",
                                    "content": {
                                        "application/json": {
                                            "schema": {
                                                "type": "object",
                                                "properties": {
                                                    "pendingDocuments": {
                                                        "type": "string",
                                                        "description": "The list of pending documents for the claim."
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    },
                    "/send-reminders": {
                        "post": {
                            "summary": "API to send reminder to the customer about pending documents for open claim",
                            "description": "Send reminder to the customer about pending documents for open claim. The API takes in only one claim id and its pending documents at a time, sends the reminder and returns the tracking details for the reminder. This API should be called for each claim id you want to send reminders for.",
                            "operationId": "sendReminders",
                            "requestBody": {
                                "required": true,
                                "content": {
                                    "application/json": {
                                        "schema": {
                                            "type": "object",
                                            "properties": {
                                                "claimId": {
                                                    "type": "string",
                                                    "description": "Unique ID of open claims to send reminders for."
                                                },
                                                "pendingDocuments": {
                                                    "type": "string",
                                                    "description": "The list of pending documents for the claim."
                                                }
                                            },
                                            "required": [
                                                "claimId",
                                                "pendingDocuments"
                                            ]
                                        }
                                    }
                                }
                            },
                            "responses": {
                                "200": {
                                    "description": "Reminders sent successfully",
                                    "content": {
                                        "application/json": {
                                            "schema": {
                                                "type": "object",
                                                "properties": {
                                                    "sendReminderTrackingId": {
                                                        "type": "string",
                                                        "description": "Unique Id to track the status of the send reminder Call"
                                                    },
                                                    "sendReminderStatus": {
                                                        "type": "string",
                                                        "description": "Status of send reminder notifications"
                                                    }
                                                }
                                            }
                                        }
                                    }
                                },
                                "400": {
                                    "description": "Bad request. One or more required fields are missing or invalid."
                                }
                            }
                        }
                    }
                }
            }',
            'schema' => new OpenApi(
                openapi: '3.0.0',
                info: new Info(
                    title: 'Insurance Claims Automation API',
                    version: '1.0.0',
                    description: 'APIs for managing insurance claims by pulling a list of open claims, identifying outstanding paperwork for each claim, and sending reminders to policy holders.',
                ),
                paths: Paths::fromArray([
                    '/claims' => new PathItem(
                        get: new Operation(
                            summary: 'Get a list of all open claims',
                            description: 'Get the list of all open insurance claims. Return all the open claimIds.',
                            operationId: 'getAllOpenClaims',
                            responses: Responses::fromArray([
                                '200' => new Response(
                                    description: 'Gets the list of all open insurance claims for policy holders',
                                    content: MediaTypeMap::fromArray([
                                        'application/json' => new MediaType(
                                            schema: new Schema(
                                                type: 'array',
                                                items: new Schema(
                                                    type: 'object',
                                                    properties: SchemasMap::fromArray([
                                                        'claimId' => new Schema(
                                                            type: 'string',
                                                            description: 'Unique ID of the claim.',
                                                        ),
                                                        'policyHolderId' => new Schema(
                                                            type: 'string',
                                                            description: 'Unique ID of the policy holder who has filed the claim.',
                                                        ),
                                                        'claimStatus' => new Schema(
                                                            type: 'string',
                                                            description: 'The status of the claim. Claim can be in Open or Closed state',
                                                        ),
                                                    ]),
                                                ),
                                            ),
                                        ),
                                    ]),
                                ),
                            ]),
                        ),
                    ),
                    '/claims/{claimId}/identify-missing-documents' => new PathItem(
                        get: new Operation(
                            summary: 'Identify missing documents for a specific claim',
                            description: 'Get the list of pending documents that need to be uploaded by policy holder before the claim can be processed. The API takes in only one claim id and returns the list of documents that are pending to be uploaded by policy holder for that claim. This API should be called for each claim id',
                            operationId: 'identifyMissingDocuments',
                            parameters: ParametersMap::fromArray([
                                new Parameter(
                                    name: 'claimId',
                                    in: 'path',
                                    description: 'Unique ID of the open insurance claim',
                                    required: true,
                                    schema: new Schema(
                                        type: 'string',
                                    ),
                                ),
                            ]),
                            responses: Responses::fromArray([
                                '200' => new Response(
                                    description: 'List of documents that are pending to be uploaded by policy holder for insurance claim',
                                    content: MediaTypeMap::fromArray([
                                        'application/json' => new MediaType(
                                            schema: new Schema(
                                                type: 'object',
                                                properties: SchemasMap::fromArray([
                                                    'pendingDocuments' => new Schema(
                                                        type: 'string',
                                                        description: 'The list of pending documents for the claim.',
                                                    ),
                                                ]),
                                            ),
                                        ),
                                    ]),
                                ),
                            ]),
                        ),
                    ),
                    '/send-reminders' => new PathItem(
                        post: new Operation(
                            summary: 'API to send reminder to the customer about pending documents for open claim',
                            description: 'Send reminder to the customer about pending documents for open claim. The API takes in only one claim id and its pending documents at a time, sends the reminder and returns the tracking details for the reminder. This API should be called for each claim id you want to send reminders for.',
                            operationId: 'sendReminders',
                            requestBody: new RequestBody(
                                content: MediaTypeMap::fromArray([
                                    'application/json' => new MediaType(
                                        schema: new Schema(
                                            type: 'object',
                                            required: [
                                                'claimId',
                                                'pendingDocuments',
                                            ],
                                            properties: SchemasMap::fromArray([
                                                'claimId' => new Schema(
                                                    type: 'string',
                                                    description: 'Unique ID of open claims to send reminders for.',
                                                ),
                                                'pendingDocuments' => new Schema(
                                                    type: 'string',
                                                    description: 'The list of pending documents for the claim.',
                                                ),
                                            ]),
                                        ),
                                    ),
                                ]),
                                required: true,
                            ),
                            responses: Responses::fromArray([
                                '200' => new Response(
                                    description: 'Reminders sent successfully',
                                    content: MediaTypeMap::fromArray([
                                        'application/json' => new MediaType(
                                            schema: new Schema(
                                                type: 'object',
                                                properties: SchemasMap::fromArray([
                                                    'sendReminderTrackingId' => new Schema(
                                                        type: 'string',
                                                        description: 'Unique Id to track the status of the send reminder Call',
                                                    ),
                                                    'sendReminderStatus' => new Schema(
                                                        type: 'string',
                                                        description: 'Status of send reminder notifications',
                                                    ),
                                                ]),
                                            ),
                                        ),
                                    ]),
                                ),
                                '400' => new Response(
                                    description: 'Bad request. One or more required fields are missing or invalid.',
                                ),
                            ]),
                        ),
                    ),
                ]),
            ),
        ];
    }
}